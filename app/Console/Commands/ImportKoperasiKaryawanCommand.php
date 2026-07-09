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
    /** @var array<string, string> normalized kabupaten/kota name => provinsi name */
    private array $provinsiByKabupaten = [];

    public function handle(): int
    {
        $path = $this->argument('path');

        if (! file_exists($path)) {
            $this->error("File not found: {$path}");

            return self::FAILURE;
        }

        $this->loadWilayahLookup();

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

            $kotaKabupaten = $row['H'] ?? null;

            $entry = SdmKdkmpEntry::query()->updateOrCreate(
                ['nik' => $nik],
                [
                    'nama_kodam' => $row['B'] ?? null,
                    'nama_korem' => $row['C'] ?? null,
                    'nama_kodim' => $row['D'] ?? null,
                    'nama_koperasi' => $row['E'] ?? $nik,
                    'provinsi' => $this->resolveProvinsi($kotaKabupaten),
                    'desa' => $row['F'] ?? null,
                    'kecamatan' => $row['G'] ?? null,
                    'kota_kabupaten' => $kotaKabupaten,
                    'batch' => $row['N'] ?? null,
                ],
            );

            $entry->wasRecentlyCreated ? $created++ : $updated++;
        }

        $this->info("Imported {$created} new koperasi, refreshed {$updated} existing koperasi.");

        return self::SUCCESS;
    }

    private function loadWilayahLookup(): void
    {
        $kabupatenPath = database_path('data/wilayah-kabupaten-kota.json');
        $provinsiPath = database_path('data/wilayah-provinsi.json');

        $provinsiById = [];
        foreach ($this->readJsonLines($provinsiPath) as $provinsi) {
            $provinsiById[$provinsi['id']] = $provinsi['nama'];
        }

        foreach ($this->readJsonLines($kabupatenPath) as $kabupaten) {
            $key = $this->normalizeKabupatenName($kabupaten['nama']);
            $this->provinsiByKabupaten[$key] = $provinsiById[$kabupaten['provinsi_id']] ?? null;
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function readJsonLines(string $path): array
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return array_map(fn (string $line): array => json_decode($line, true), $lines);
    }

    private function resolveProvinsi(?string $kotaKabupaten): ?string
    {
        if (! $kotaKabupaten) {
            return null;
        }

        return $this->provinsiByKabupaten[$this->normalizeKabupatenName($kotaKabupaten)] ?? null;
    }

    private function normalizeKabupatenName(string $name): string
    {
        $name = preg_replace('/^(kota|kabupaten)\s+/i', '', trim($name));

        return mb_strtolower($name ?? '');
    }
}
