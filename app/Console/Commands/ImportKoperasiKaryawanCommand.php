<?php

namespace App\Console\Commands;

use App\Models\SdmKdkmpEntry;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

#[Signature('import:koperasi-karyawan {path : Path to the Export_Laporan_Koperasi xlsx file}')]
#[Description('Import/refresh koperasi reference data (NIK, nama, wilayah) used by the SDM data table. Does not touch jumlah_karyawan.')]
class ImportKoperasiKaryawanCommand extends Command
{
    public function handle(): int
    {
        $path = $this->argument('path');

        if (! file_exists($path)) {
            $this->error("File not found: {$path}");

            return self::FAILURE;
        }

        $sheet = IOFactory::load($path)->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);
        array_shift($rows);

        $created = 0;
        $updated = 0;

        foreach ($rows as $row) {
            $nik = trim((string) ($row['A'] ?? ''));

            if ($nik === '') {
                continue;
            }

            $entry = SdmKdkmpEntry::query()->updateOrCreate(
                ['nik' => $nik],
                [
                    'nama_kodam' => $row['B'] ?? null,
                    'nama_korem' => $row['C'] ?? null,
                    'nama_kodim' => $row['D'] ?? null,
                    'nama_koperasi' => $row['E'] ?? $nik,
                    'desa' => $row['F'] ?? null,
                    'kecamatan' => $row['G'] ?? null,
                    'kota_kabupaten' => $row['H'] ?? null,
                    'batch' => $row['N'] ?? null,
                ],
            );

            $entry->wasRecentlyCreated ? $created++ : $updated++;
        }

        $this->info("Imported {$created} new koperasi, refreshed {$updated} existing koperasi.");

        return self::SUCCESS;
    }
}
