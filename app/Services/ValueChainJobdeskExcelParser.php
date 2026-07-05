<?php

namespace App\Services;

use App\Models\Organization;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ValueChainJobdeskExcelParser
{
    private const SHEET_NAME = '3. ValueChain & JobDesc';

    public function parse(string $filePath): array
    {
        $spreadsheet = IOFactory::load($filePath);

        $sheet = $spreadsheet->getSheetByName(self::SHEET_NAME);

        if (! $sheet) {
            return [
                'profiles' => [],
                'errors' => [
                    [
                        'sheet_name' => self::SHEET_NAME,
                        'row_number' => null,
                        'message' => 'Sheet 3. ValueChain & JobDesc tidak ditemukan.',
                        'payload' => null,
                    ],
                ],
            ];
        }

        return $this->parseSheet($sheet);
    }

    private function parseSheet(Worksheet $sheet): array
    {
        $highestColumn = $sheet->getHighestDataColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        $organizations = Organization::query()
            ->get()
            ->keyBy('code');

        $profiles = [];
        $errors = [];

        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $organizationHeader = $this->cell($sheet, $col, 3);

            $header = $this->detectOrganizationHeader($organizationHeader);

            if (! $header) {
                continue;
            }

            $organization = $organizations->get($header['code']);

            if (! $organization) {
                $errors[] = [
                    'sheet_name' => $sheet->getTitle(),
                    'row_number' => 3,
                    'message' => "Kode organisasi {$header['code']} tidak ditemukan di database.",
                    'payload' => $header,
                ];

                continue;
            }

            $jobDescription = $this->cleanText($this->cell($sheet, $col, 4));
            $qualification = $this->cleanText($this->cell($sheet, $col, 5));
            $valueChain = $this->cleanText($this->cell($sheet, $col, 15));
            $methodCost = $this->toNumber($this->cell($sheet, $col, 16));

            $profiles[] = [
                'organization_id' => $organization->id,
                'organization_code' => $organization->code,
                'organization_name' => $organization->name,
                'source_sheet' => $sheet->getTitle(),
                'job_description' => $jobDescription,
                'qualification' => $qualification,
                'value_chain' => $valueChain,
                'method_cost' => $methodCost,
                'raw_payload' => [
                    'excel_header' => $organizationHeader,
                    'detected_code' => $header['code'],
                    'detected_name' => $header['name'],
                    'excel_column' => Coordinate::stringFromColumnIndex($col),
                    'job_description_row' => 4,
                    'qualification_row' => 5,
                    'value_chain_row' => 15,
                    'method_cost_row' => 16,
                ],
            ];
        }

        return [
            'profiles' => $profiles,
            'errors' => $errors,
        ];
    }

    private function cell(Worksheet $sheet, int $col, int $row): mixed
    {
        $address = Coordinate::stringFromColumnIndex($col).$row;

        return $sheet->getCell($address)->getCalculatedValue();
    }

    private function detectOrganizationHeader(mixed $cell): ?array
    {
        $text = $this->cleanText($cell);

        if ($text === '') {
            return null;
        }

        $pattern = '/^((?:\d+)(?:\s*\.\s*[A-Z])?(?:\s*\.\s*\d+)*)(?:\s*\.?\s+)(.+)$/u';

        if (! preg_match($pattern, $text, $matches)) {
            return null;
        }

        $code = preg_replace('/\s+/', '', $matches[1]);
        $code = rtrim($code, '.');

        return [
            'code' => $code,
            'name' => trim($matches[2]),
        ];
    }

    private function cleanText(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        return trim((string) $value);
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

        if (in_array($text, ['-', '#DIV/0!', '#VALUE!', '#REF!'], true)) {
            return null;
        }

        $text = str_replace(['Rp', 'rp', '%', ' ', ','], '', $text);

        if (! is_numeric($text)) {
            return null;
        }

        return (float) $text;
    }
}
