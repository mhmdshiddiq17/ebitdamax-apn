<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $rows = $this->organizationRows();
        $activeCodes = array_column($rows, 'code');

        Organization::query()
            ->whereNotIn('code', $activeCodes)
            ->update(['is_active' => false]);

        $organizationsByCode = [];
        $sortOrder = 1;

        foreach ($rows as $row) {
            $parent = $this->resolveParent($row['code'], $organizationsByCode);
            $metadata = $this->metadataFor($row['code'], $row['name'], $parent);
            $path = $parent ? $parent->path.'/'.$row['code'] : $row['code'];

            $organization = Organization::query()->updateOrCreate(
                ['code' => $row['code']],
                [
                    'parent_id' => $parent?->id,
                    'name' => $row['name'],
                    'slug' => Str::slug($row['code'].'-'.$row['name']),
                    'depth' => $parent ? $parent->depth + 1 : 0,
                    'path' => $path,
                    'level' => $metadata['level'],
                    'node_type' => $metadata['node_type'],
                    'directorate_group' => $metadata['directorate_group'],
                    'is_revenue_center' => $metadata['is_revenue_center'],
                    'is_cost_center' => $metadata['is_cost_center'],
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]
            );

            $organizationsByCode[$organization->code] = $organization;
        }
    }

    /**
     * @return array<int, array{code: string, name: string}>
     */
    private function organizationRows(): array
    {
        return [
            ['code' => '1', 'name' => 'Direktur Utama'],
            ['code' => '1.A', 'name' => 'Wakil Direktur Utama I'],
            ['code' => '1.A.1', 'name' => 'Direktur Perencanaan dan Pengembangan Bisnis'],
            ['code' => '1.A.1.1', 'name' => 'Corporate Strartegy and Planning'],
            ['code' => '1.A.1.1.1', 'name' => 'Strategy Planning'],
            ['code' => '1.A.1.1.2', 'name' => 'Portfolio and Performance'],
            ['code' => '1.A.1.1.3', 'name' => 'Business and Analytics and Valuation'],
            ['code' => '1.A.1.2', 'name' => 'Business Development, Partnership and Technology'],
            ['code' => '1.A.1.2.1', 'name' => 'Business Development'],
            ['code' => '1.A.1.2.2', 'name' => 'Partnership and Ecosystem'],
            ['code' => '1.A.1.2.3', 'name' => 'Technology and Digital for Business Enablement'],
            ['code' => '1.A.1.3', 'name' => 'PMO (Project Management Office) and Transformation'],
            ['code' => '1.A.1.4', 'name' => 'Research, Innovation and Development'],
            ['code' => '1.A.2', 'name' => 'Direktur Sumber Daya Manusia'],
            ['code' => '1.A.2.1', 'name' => 'HC Service'],
            ['code' => '1.A.2.1.1', 'name' => 'Talent Aqcuisition-Human Resources Business'],
            ['code' => '1.A.2.1.2', 'name' => 'People Development - Talent Mangement'],
            ['code' => '1.A.2.2', 'name' => 'HC Startegy'],
            ['code' => '1.A.2.2.1', 'name' => 'Compensation and Performance Management'],
            ['code' => '1.A.2.2.2', 'name' => 'Employee Engagement Management'],
            ['code' => '1.A.2.2.3', 'name' => 'Industrial Relation'],
            ['code' => '1.A.2.3', 'name' => 'HC GA & Operations'],
            ['code' => '1.A.2.3.1', 'name' => 'Personalia'],
            ['code' => '1.A.2.3.2', 'name' => 'General Affairs'],
            ['code' => '1.A.3', 'name' => 'Direktur Pengadaan dan Logistik'],
            ['code' => '1.A.3.1', 'name' => 'Procurement & Contract Management'],
            ['code' => '1.A.3.1.1', 'name' => 'Strategic Sourcing and Category Management'],
            ['code' => '1.A.3.1.2', 'name' => 'Procurement Execution'],
            ['code' => '1.A.3.1.3', 'name' => 'Vendor and Contract Management'],
            ['code' => '1.A.3.2', 'name' => 'Supply Chain & Logistik'],
            ['code' => '1.A.3.2.1', 'name' => 'Supply Planning and Inventory'],
            ['code' => '1.A.3.2.2', 'name' => 'Logistic and Operation'],
            ['code' => '1.A.3.2.3', 'name' => 'Warehouse and Distribution'],
            ['code' => '1.A.4', 'name' => 'Direktur Operasional'],
            ['code' => '1.A.4.1', 'name' => 'Corporate - Regional Affairs and Coordination'],
            ['code' => '1.A.4.1.1', 'name' => 'Regional Coordination'],
            ['code' => '1.A.4.1.2', 'name' => 'Stakeholder and Community Relations'],
            ['code' => '1.A.4.2', 'name' => 'QSHE (Quality, Safety, Health and Environment) Governance and Assurance'],
            ['code' => '1.A.4.3', 'name' => 'Business Process Improvement'],
            ['code' => '1.A.5', 'name' => 'Direktur Pangan'],
            ['code' => '1.A.5.1', 'name' => 'KSPP'],
            ['code' => '1.A.5.1.1', 'name' => 'KSPP Development'],
            ['code' => '1.A.5.1.2', 'name' => 'KSPP Operations'],
            ['code' => '1.A.5.1.3', 'name' => 'KSPP Planning and Operation Control'],
            ['code' => '1.A.5.2', 'name' => 'Agro Production & Livestock Management'],
            ['code' => '1.A.5.2.1', 'name' => 'Crop Production'],
            ['code' => '1.A.5.2.2', 'name' => 'Livestock Management'],
            ['code' => '1.A.5.2.3', 'name' => 'Farmer and Breeder Engagement'],
            ['code' => '1.A.5.2.4', 'name' => 'Crop and Food Production'],
            ['code' => '1.A.5.3', 'name' => 'Processing and Food Production'],
            ['code' => '1.A.5.3.1', 'name' => 'Food Processing (Crop Based)'],
            ['code' => '1.A.5.3.2', 'name' => 'Dairy and Meat Processing'],
            ['code' => '1.A.5.3.3', 'name' => 'Facility and Maintenance'],
            ['code' => '1.A.5.4', 'name' => 'Technical Agribusiness & Land Development'],
            ['code' => '1.A.5.4.1', 'name' => 'Agronomy and Crop System'],
            ['code' => '1.A.5.4.2', 'name' => 'Livestock system and nutrition'],
            ['code' => '1.A.5.4.3', 'name' => 'Land and Topography Development'],
            ['code' => '1.A.6', 'name' => 'Direktur Retail dan Distribusi'],
            ['code' => '1.A.6.1', 'name' => 'Retail Performnace and Demand Management'],
            ['code' => '1.A.6.1.1', 'name' => 'Demand Planning and Forecast'],
            ['code' => '1.A.6.1.2', 'name' => 'Replenishment Planning'],
            ['code' => '1.A.6.1.3', 'name' => 'Retail Performance Analyst'],
            ['code' => '1.A.6.2', 'name' => 'Distribution and Availability Management'],
            ['code' => '1.A.6.2.1', 'name' => 'Distribution Coordination'],
            ['code' => '1.A.6.2.2', 'name' => 'Availability and Replenishment Execution'],
            ['code' => '1.A.6.2.3', 'name' => 'Inventory Control'],
            ['code' => '1.A.6.3', 'name' => 'Retail Operations'],
            ['code' => '1.A.6.3.1', 'name' => 'KDKMP Operation'],
            ['code' => '1.A.6.3.2', 'name' => 'Field Operation dan SOP Standard'],
            ['code' => '1.A.6.4', 'name' => 'Sales and Channel Management'],
            ['code' => '1.A.6.4.1', 'name' => 'Principal and Strategic Account'],
            ['code' => '1.A.6.4.2', 'name' => 'Ecosystem and UMKM Sourching'],
            ['code' => '1.A.6.4.3', 'name' => 'Promotion and Pricing Management'],
            ['code' => '1.A.7', 'name' => 'Direktur Keuangan dan Manajemen Risiko'],
            ['code' => '1.A.7.1', 'name' => 'Keuangan'],
            ['code' => '1.A.7.1.1', 'name' => 'Funding'],
            ['code' => '1.A.7.1.2', 'name' => 'Treasury'],
            ['code' => '1.A.7.1.3', 'name' => 'Collection - Corporate'],
            ['code' => '1.A.7.1.4', 'name' => 'Collection - Retail dan Distribusi'],
            ['code' => '1.A.7.2', 'name' => 'Akuntansi, Pajak, dan Anggaran'],
            ['code' => '1.A.7.2.1', 'name' => 'Akuntansi'],
            ['code' => '1.A.7.2.2', 'name' => 'Pajak'],
            ['code' => '1.A.7.2.3', 'name' => 'Pengendalian Anggaran'],
            ['code' => '1.A.7.3', 'name' => 'Controller'],
            ['code' => '1.A.7.3.1', 'name' => 'Billing'],
            ['code' => '1.A.7.3.2', 'name' => 'Pengendalian Biaya - Unit'],
            ['code' => '1.A.7.3.3', 'name' => 'Revenue Assurance - Pengendalian Biaya Corporate'],
            ['code' => '1.A.7.4', 'name' => 'Manajemen Risiko & Kepatuhan'],
            ['code' => '1.A.7.4.1', 'name' => 'Manajemen Risiko'],
            ['code' => '1.A.7.4.2', 'name' => 'Manajemen Kepatuhan'],
            ['code' => '1.A.8', 'name' => 'Direktur Teknik dan Konsultan Enjiniring'],
            ['code' => '1.A.8.1', 'name' => 'Teknik'],
            ['code' => '1.A.8.1.1', 'name' => 'Design'],
            ['code' => '1.A.8.1.2', 'name' => 'Perencanaan'],
            ['code' => '1.A.8.1.3', 'name' => 'Manajemen Konstruksi'],
            ['code' => '1.A.8.2', 'name' => 'Pemasaran'],
            ['code' => '1.A.8.2.1', 'name' => 'Tender dan Proposal'],
            ['code' => '1.A.8.2.2', 'name' => 'Customer Relations'],
            ['code' => '1.A.8.2.3', 'name' => 'Kemitraan Strategis & Market Intelegence'],
            ['code' => '1.A.8.3', 'name' => 'Operasional'],
            ['code' => '1.A.8.3.1', 'name' => 'Building Management'],
            ['code' => '1.A.8.3.2', 'name' => 'Engineering'],
            ['code' => '1.A.8.3.3', 'name' => 'Infrastruktur'],
            ['code' => '1.A.8.3.4', 'name' => 'Gedung'],
            ['code' => '1.A.8.3.5', 'name' => 'Pemukiman & Pengembangan'],
            ['code' => '1.A.8.4', 'name' => 'Kantor Wilayah'],
            ['code' => '1.A.8.5', 'name' => 'Production Planning and Control'],
            ['code' => '1.B.1', 'name' => 'SVP Corporate Secretary'],
            ['code' => '1.B.1.1', 'name' => 'Sekretaris Direksi'],
            ['code' => '1.B.1.2', 'name' => 'Humas'],
            ['code' => '1.B.1.3', 'name' => 'Umum'],
            ['code' => '1.B.2', 'name' => 'SVP Legal'],
            ['code' => '1.B.2.1', 'name' => 'Legal'],
            ['code' => '1.B.3', 'name' => 'VP Internal Audit'],
            ['code' => '1.B.3.1', 'name' => 'Internal Audit'],
            ['code' => '1.B.4', 'name' => 'VP Pengamanan'],
            ['code' => '1.B.4.1', 'name' => 'Tim Pengamanan'],
            ['code' => '1.B.5', 'name' => 'VP Information Technology'],
            ['code' => '1.B.5.1', 'name' => 'IT'],
            ['code' => '1.C.1', 'name' => 'Direktur Wilayah Sumatera'],
            ['code' => '1.C.2', 'name' => 'Direktur Wilayah Sulawesi'],
            ['code' => '1.C.3', 'name' => 'Direktur Wilayah Maluku Papua'],
            ['code' => '1.C.4', 'name' => 'Direktur Wilayah Kalimantan'],
            ['code' => '1.C.5', 'name' => 'Direktur Wilayah Jawa'],
            ['code' => '1.C.6', 'name' => 'Direktur Wilayah Bali Nusra'],
        ];
    }

    /**
     * @param  array<string, Organization>  $organizationsByCode
     */
    private function resolveParent(string $code, array $organizationsByCode): ?Organization
    {
        $parentCode = $this->parentCode($code);

        while ($parentCode !== null) {
            if (isset($organizationsByCode[$parentCode])) {
                return $organizationsByCode[$parentCode];
            }

            $parentCode = $this->parentCode($parentCode);
        }

        return null;
    }

    private function parentCode(string $code): ?string
    {
        $lastDotPosition = strrpos($code, '.');

        if ($lastDotPosition === false) {
            return null;
        }

        return substr($code, 0, $lastDotPosition);
    }

    /**
     * @return array{level: string, node_type: string, directorate_group: string|null, is_revenue_center: bool, is_cost_center: bool}
     */
    private function metadataFor(string $code, string $name, ?Organization $parent): array
    {
        $level = $this->levelFor($code, $name, $parent);
        $isRevenueCenter = $this->isRevenueCenter($code);

        return [
            'level' => $level,
            'node_type' => $this->nodeTypeFor($code, $level),
            'directorate_group' => $this->directorateGroupFor($code, $name, $level, $parent),
            'is_revenue_center' => $isRevenueCenter,
            'is_cost_center' => ! $isRevenueCenter,
        ];
    }

    private function levelFor(string $code, string $name, ?Organization $parent): string
    {
        if ($code === '1') {
            return 'Direktur Utama';
        }

        if ($code === '1.A') {
            return 'Wakil Direktur Utama';
        }

        if (str_starts_with($name, 'SVP ')) {
            return 'SVP';
        }

        if (str_starts_with($name, 'VP ')) {
            return 'VP';
        }

        if (str_starts_with($name, 'Direktur ')) {
            return 'Direktorat';
        }

        if ($parent?->level === 'Direktorat') {
            return 'Sub Direktorat';
        }

        return 'Unit';
    }

    private function nodeTypeFor(string $code, string $level): string
    {
        if ($code === '1') {
            return 'root';
        }

        if ($code === '1.A') {
            return 'deputy_director';
        }

        if (str_starts_with($code, '1.B.') && in_array($level, ['SVP', 'VP'], true)) {
            return 'support_center';
        }

        if (str_starts_with($code, '1.C.')) {
            return 'regional_center';
        }

        return match ($level) {
            'Direktorat' => 'directorate',
            'Sub Direktorat' => 'division',
            default => 'unit',
        };
    }

    private function directorateGroupFor(
        string $code,
        string $name,
        string $level,
        ?Organization $parent
    ): ?string {
        if (in_array($code, ['1', '1.A'], true)) {
            return null;
        }

        if (str_starts_with($code, '1.B.')) {
            return 'Corporate Function';
        }

        if (str_starts_with($code, '1.C.')) {
            return 'Wilayah';
        }

        if ($level === 'Direktorat') {
            return trim((string) preg_replace('/^Direktur\s+/i', '', $name));
        }

        return $parent?->directorate_group;
    }

    private function isRevenueCenter(string $code): bool
    {
        foreach (['1.A.5', '1.A.6', '1.A.8'] as $prefix) {
            if ($code === $prefix || str_starts_with($code, $prefix.'.')) {
                return true;
            }
        }

        return false;
    }
}
