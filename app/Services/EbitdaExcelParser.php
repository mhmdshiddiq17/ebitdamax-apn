<?php

namespace App\Services;

use App\Models\EbitdaValue;
use App\Models\Organization;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EbitdaExcelParser
{
    private array $metricLabels = [
        'total revenue (rp)' => 'revenue',
        'doc-v (rp)' => 'doc_variable',
        'doc-f (rp)' => 'doc_fixed',
        'ioc (rp)' => 'ioc',
        'toc (rp)' => 'toc',
        'ebitda (rp)' => 'ebitda',
        'ebitda margin (%)' => 'ebitda_margin',
    ];

    private array $scenarioLabels = [
        'target tahunan' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'target harian' => EbitdaValue::SCENARIO_TARGET_HARIAN,
        'plan harian' => EbitdaValue::SCENARIO_PLAN_HARIAN,
        'aktual harian' => EbitdaValue::SCENARIO_AKTUAL_HARIAN,
    ];

    public function parse(string $filePath, int $year): array
    {
        $spreadsheet = IOFactory::load($filePath);

        $organizations = Organization::query()
            ->get()
            ->keyBy('code');

        $records = [];
        $errors = [];

        $sheets = $this->chooseSheets($spreadsheet);

        foreach ($sheets as $sheet) {
            $result = $this->parseSheet($sheet, $organizations, $year);

            $records = array_merge($records, $result['records']);
            $errors = array_merge($errors, $result['errors']);
        }

        return [
            'records' => $records,
            'errors' => $errors,
        ];
    }

    private function chooseSheets($spreadsheet): array
    {
        $preferredNames = [
            'WIP - EBITDA Matrix #3',
            'WIP - EBITDA Matrix #2',
            'WIP - EBITDA Matrix #1',
            'EBITDA Matrix',
            'Dashboard',
        ];

        $available = [];

        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            $available[$worksheet->getTitle()] = $worksheet;
        }

        foreach ($preferredNames as $preferredName) {
            if (isset($available[$preferredName])) {
                return [$available[$preferredName]];
            }
        }

        return iterator_to_array($spreadsheet->getWorksheetIterator());
    }

    private function parseSheet(Worksheet $sheet, $organizations, int $year): array
    {
        $highestRow = $sheet->getHighestDataRow();
        $highestColumn = $sheet->getHighestDataColumn();

        $rows = $sheet->rangeToArray(
            "A1:{$highestColumn}{$highestRow}",
            null,
            true,
            true,
            false
        );

        $records = [];
        $errors = [];

        foreach ($rows as $rowIndex => $row) {
            foreach ($row as $colIndex => $cell) {
                $header = $this->detectOrganizationHeader($cell);

                if (! $header) {
                    continue;
                }

                $organization = $organizations->get($header['code']);

                if (! $organization) {
                    $errors[] = [
                        'sheet_name' => $sheet->getTitle(),
                        'row_number' => $rowIndex + 1,
                        'message' => "Kode organisasi {$header['code']} tidak ditemukan di database.",
                        'payload' => $header,
                    ];

                    continue;
                }

                $scenarios = $this->detectScenarios($row, $colIndex);

                if (count($scenarios) === 0) {
                    continue;
                }

                $metricBlock = $this->readMetricBlock($rows, $rowIndex, $colIndex, $scenarios);

                foreach ($metricBlock as $scenario => $metrics) {
                    if (! $this->hasAnyMetricValue($metrics)) {
                        continue;
                    }

                    $docVariable = (float) ($metrics['doc_variable'] ?? 0);
                    $docFixed = (float) ($metrics['doc_fixed'] ?? 0);
                    $ioc = (float) ($metrics['ioc'] ?? 0);
                    $revenue = (float) ($metrics['revenue'] ?? 0);

                    $toc = isset($metrics['toc'])
                        ? (float) $metrics['toc']
                        : EbitdaValue::calculateToc($docVariable, $docFixed, $ioc);

                    $ebitda = isset($metrics['ebitda'])
                        ? (float) $metrics['ebitda']
                        : EbitdaValue::calculateEbitda($revenue, $toc);

                    $ebitdaMargin = EbitdaValue::calculateMargin($revenue, $ebitda);

                    $records[] = [
                        'organization_id' => $organization->id,
                        'organization_code' => $organization->code,
                        'organization_name' => $organization->name,
                        'year' => $year,
                        'period_date' => null,
                        'scenario' => $scenario,
                        'source_sheet' => $sheet->getTitle(),
                        'revenue' => $revenue,
                        'doc_variable' => $docVariable,
                        'doc_fixed' => $docFixed,
                        'ioc' => $ioc,
                        'toc' => $toc,
                        'ebitda' => $ebitda,
                        'ebitda_margin' => $ebitdaMargin,
                        'raw_payload' => $metrics,
                    ];
                }
            }
        }

        return [
            'records' => $records,
            'errors' => $errors,
        ];
    }

    private function detectOrganizationHeader(mixed $cell): ?array
    {
        $text = $this->normalizeHeaderText($cell);

        if ($text === '') {
            return null;
        }

        $pattern = '/^((?:\d+)(?:\s*\.\s*[A-Za-z])?(?:\s*\.\s*\d+)*)(?:\s*\.?\s+)(.+)$/u';

        if (! preg_match($pattern, $text, $matches)) {
            return null;
        }

        $code = strtoupper((string) preg_replace('/\s+/', '', $matches[1]));
        $code = rtrim($code, '.');
        $name = trim($matches[2]);

        return [
            'code' => $code,
            'name' => $name,
        ];
    }

    private function detectScenarios(array $row, int $startCol): array
    {
        $scenarios = [];

        $maxCol = min(count($row) - 1, $startCol + 8);

        for ($col = $startCol + 1; $col <= $maxCol; $col++) {
            $text = $this->normalizeText($row[$col] ?? '');

            foreach ($this->scenarioLabels as $keyword => $scenario) {
                if (str_contains($text, $keyword)) {
                    $scenarios[$scenario] = $col;
                }
            }
        }

        return $scenarios;
    }

    private function readMetricBlock(array $rows, int $headerRow, int $labelCol, array $scenarios): array
    {
        $result = [];

        foreach (array_keys($scenarios) as $scenario) {
            $result[$scenario] = [];
        }

        $maxRow = min(count($rows) - 1, $headerRow + 12);

        for ($rowIndex = $headerRow + 1; $rowIndex <= $maxRow; $rowIndex++) {
            $label = $this->normalizeText($rows[$rowIndex][$labelCol] ?? '');

            if (! isset($this->metricLabels[$label])) {
                continue;
            }

            $metricKey = $this->metricLabels[$label];

            foreach ($scenarios as $scenario => $valueCol) {
                $value = $this->toNumber($rows[$rowIndex][$valueCol] ?? null);

                if ($value !== null) {
                    $result[$scenario][$metricKey] = $value;
                }
            }
        }

        return $result;
    }

    private function hasAnyMetricValue(array $metrics): bool
    {
        foreach ($metrics as $value) {
            if ($value !== null) {
                return true;
            }
        }

        return false;
    }

    private function normalizeText(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        return strtolower(trim(preg_replace('/\s+/', ' ', (string) $value)));
    }

    private function normalizeHeaderText(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        return trim((string) preg_replace('/\s+/', ' ', (string) $value));
    }

    private function toNumber(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $text = trim((string) $value);

        if ($text === '-' || $text === '#DIV/0!' || $text === '#VALUE!' || $text === '#REF!') {
            return null;
        }

        $text = str_replace(['Rp', 'rp', '%', ' ', ','], '', $text);

        if (! is_numeric($text)) {
            return null;
        }

        return (float) $text;
    }
}
