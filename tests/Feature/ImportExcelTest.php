<?php

use App\Models\EbitdaValue;
use App\Models\ExcelImport;
use App\Models\ImportErrorLog;
use App\Models\User;
use App\Services\EbitdaExcelParser;
use Database\Seeders\OrganizationSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

test('guests can visit import excel while auth middleware is bypassed', function () {
    $response = $this->get(route('import-excel.index'));

    $response->assertOk();
});

test('authenticated users can visit the import excel page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('import-excel.index'));

    $response->assertOk();
});

test('authenticated users can see import error logs on the import excel page', function () {
    $user = User::factory()->create();

    $excelImport = ExcelImport::query()->create([
        'filename' => 'imports/ebitdamax/template.xlsx',
        'original_filename' => 'template.xlsx',
        'status' => 'completed_with_errors',
        'total_rows' => 1,
        'success_rows' => 0,
        'failed_rows' => 1,
        'created_by' => $user->id,
    ]);

    ImportErrorLog::query()->create([
        'excel_import_id' => $excelImport->id,
        'sheet_name' => 'Dashboard',
        'row_number' => 12,
        'message' => 'Kode organisasi 9.X tidak ditemukan di database.',
        'payload' => [
            'code' => '9.X',
        ],
    ]);

    $this->actingAs($user);

    $response = $this->get(route('import-excel.index'));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Import/Index')
            ->where('imports.0.status', 'completed_with_errors')
            ->where('imports.0.errors.0.message', 'Kode organisasi 9.X tidak ditemukan di database.')
            ->where('imports.0.errors.0.payload.code', '9.X')
        );
});

test('ebitda excel parser imports organization codes with letter segments', function () {
    $this->seed(OrganizationSeeder::class);

    $spreadsheet = new Spreadsheet;
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('WIP - EBITDA Matrix #3');

    $writeBlock = function (int $startRow, string $header, int $baseValue) use ($sheet): void {
        $sheet->fromArray([
            $header,
            'Target Tahunan',
            'Target Harian',
            'Plan Harian',
            'Aktual Harian',
        ], null, 'A'.$startRow);

        $rows = [
            ['Total Revenue (Rp)', $baseValue, $baseValue + 1, $baseValue + 2, $baseValue + 3],
            ['DOC-V (Rp)', 100, 101, 102, 103],
            ['DOC-F (Rp)', 200, 201, 202, 203],
            ['IOC (Rp)', 300, 301, 302, 303],
            ['TOC (Rp)', 600, 603, 606, 609],
            ['EBITDA (Rp)', $baseValue - 600, $baseValue - 602, $baseValue - 604, $baseValue - 606],
            ['EBITDA Margin (%)', 40, 40, 40, 40],
        ];

        foreach ($rows as $offset => $row) {
            $sheet->fromArray($row, null, 'A'.($startRow + $offset + 1));
        }
    };

    $writeBlock(1, '1 Direktur Utama', 1000);
    $writeBlock(10, '1.A Wakil Direktur Utama I', 2000);
    $writeBlock(19, '1.A.1 Direktur Perencanaan dan Pengembangan Bisnis', 3000);

    $filePath = tempnam(sys_get_temp_dir(), 'ebitda-import-');

    try {
        (new Xlsx($spreadsheet))->save($filePath);

        $parsed = app(EbitdaExcelParser::class)->parse($filePath, 2026);
    } finally {
        if (is_string($filePath) && is_file($filePath)) {
            unlink($filePath);
        }
    }

    $records = collect($parsed['records']);
    $codes = $records->pluck('organization_code')->unique()->values();

    expect($parsed['errors'])->toBeEmpty()
        ->and($records)->toHaveCount(12)
        ->and($codes->all())->toContain('1', '1.A', '1.A.1')
        ->and($records->where('organization_code', '1.A')->pluck('scenario')->all())
        ->toContain(
            EbitdaValue::SCENARIO_TARGET_TAHUNAN,
            EbitdaValue::SCENARIO_TARGET_HARIAN,
            EbitdaValue::SCENARIO_PLAN_HARIAN,
            EbitdaValue::SCENARIO_AKTUAL_HARIAN,
        );
});

test('uploaded excel file is parsed from the configured local storage path', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $csrfToken = 'test-token';

    $this->actingAs($user);

    $this->mock(EbitdaExcelParser::class, function ($mock) {
        $mock->shouldReceive('parse')
            ->once()
            ->withArgs(function (string $filePath, int $year): bool {
                return $year === 2026
                    && str_contains($filePath, 'imports/ebitdamax')
                    && is_file($filePath);
            })
            ->andReturn([
                'records' => [],
                'errors' => [],
            ]);
    });

    $response = $this->withSession(['_token' => $csrfToken])
        ->post(route('import-excel.store'), [
            '_token' => $csrfToken,
            'year' => 2026,
            'file' => UploadedFile::fake()->create('ebitdamax.xlsx', 12),
        ]);

    $response
        ->assertRedirect()
        ->assertSessionHas('success');

    $excelImport = ExcelImport::query()->firstOrFail();

    expect(Storage::disk('local')->exists($excelImport->filename))->toBeTrue()
        ->and($excelImport->status)->toBe('completed');
});
