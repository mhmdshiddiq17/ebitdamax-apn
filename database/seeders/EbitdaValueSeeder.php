<?php

namespace Database\Seeders;

use App\Models\EbitdaValue;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class EbitdaValueSeeder extends Seeder
{
    private int $year = 2026;

    /**
     * @var array<int, string>
     */
    private array $managedSources = [
        'EBITDA Matrix #1',
        'Seeder from organization_calculations',
    ];

    public function run(): void
    {
        $records = require database_path('seeders/data/ebitda_matrix_1_values.php');

        $organizations = Organization::query()
            ->whereIn('code', collect($records)->pluck('organization_code')->unique()->all())
            ->get()
            ->keyBy('code');

        EbitdaValue::query()
            ->where('year', $this->year)
            ->whereIn('source_sheet', $this->managedSources)
            ->delete();

        foreach ($records as $record) {
            $organization = $organizations->get($record['organization_code']);

            if (! $organization) {
                continue;
            }

            $values = $record['values'];

            EbitdaValue::query()->updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'period_date' => null,
                    'year' => $this->year,
                    'scenario' => $record['scenario'],
                ],
                [
                    'excel_import_id' => null,
                    'source_sheet' => $record['source']['sheet'],
                    'revenue' => $values['revenue'],
                    'doc_variable' => $values['doc_variable'],
                    'doc_fixed' => $values['doc_fixed'],
                    'ioc' => $values['ioc'],
                    'toc' => $values['toc'],
                    'ebitda' => $values['ebitda'],
                    'ebitda_margin' => $values['ebitda_margin'],
                    'classification' => null,
                    'man_cost' => 0,
                    'method_cost' => 0,
                    'material_cost' => 0,
                    'machine_cost' => 0,
                    'raw_payload' => [
                        'source' => 'EbitdaValueSeeder',
                        'organization_code' => $organization->code,
                        'organization_name' => $organization->name,
                        ...$record['source'],
                    ],
                ]
            );
        }
    }
}
