<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        Organization::query()->delete();

        $tree = [
            [
                'code' => '1',
                'name' => 'Direktur Utama',
                'level' => 'Direktur Utama',
                'node_type' => 'root',
                'children' => [
                    [
                        'code' => '1.C',
                        'name' => 'Corporate Secretary, Legal, Internal Audit, Pengamanan, Information Technology',
                        'level' => 'Corporate Function',
                        'node_type' => 'support_center',
                        'children' => [
                            [
                                'code' => '1.C.1',
                                'name' => 'SVP Corporate Secretary',
                                'level' => 'SVP',
                                'children' => [
                                    ['code' => '1.C.1.1', 'name' => 'Sekretaris Direksi', 'level' => 'Unit'],
                                    ['code' => '1.C.1.2', 'name' => 'Humas', 'level' => 'Unit'],
                                    ['code' => '1.C.1.3', 'name' => 'Umum', 'level' => 'Unit'],
                                ],
                            ],
                            [
                                'code' => '1.C.2',
                                'name' => 'SVP Legal',
                                'level' => 'SVP',
                                'children' => [
                                    ['code' => '1.C.2.1', 'name' => 'Legal', 'level' => 'Unit'],
                                ],
                            ],
                            [
                                'code' => '1.C.3',
                                'name' => 'VP Internal Audit',
                                'level' => 'VP',
                                'children' => [
                                    ['code' => '1.C.3.1', 'name' => 'Internal Audit', 'level' => 'Unit'],
                                ],
                            ],
                            [
                                'code' => '1.C.4',
                                'name' => 'VP Pengamanan',
                                'level' => 'VP',
                                'children' => [
                                    ['code' => '1.C.4.1', 'name' => 'Tim Pengamanan', 'level' => 'Unit'],
                                ],
                            ],
                            [
                                'code' => '1.C.5',
                                'name' => 'VP Information Technology',
                                'level' => 'VP',
                                'children' => [
                                    ['code' => '1.C.5.1', 'name' => 'IT', 'level' => 'Unit'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'code' => '1.D',
                        'name' => 'Direktur Wilayah',
                        'level' => 'Direktorat',
                        'node_type' => 'regional_center',
                        'children' => [
                            ['code' => '1.D.1', 'name' => 'Direktur Wilayah Sumatera', 'level' => 'Regional'],
                            ['code' => '1.D.2', 'name' => 'Direktur Wilayah Sulawesi', 'level' => 'Regional'],
                            ['code' => '1.D.3', 'name' => 'Direktur Wilayah Maluku Papua', 'level' => 'Regional'],
                            ['code' => '1.D.4', 'name' => 'Direktur Wilayah Kalimantan', 'level' => 'Regional'],
                            ['code' => '1.D.5', 'name' => 'Direktur Wilayah Jawa', 'level' => 'Regional'],
                            ['code' => '1.D.6', 'name' => 'Direktur Wilayah Bali Nusra', 'level' => 'Regional'],
                        ],
                    ],
                    [
                        'code' => '1.A',
                        'name' => 'Wakil Direktur Utama I',
                        'level' => 'Wakil Direktur Utama',
                        'children' => [
                            [
                                'code' => '1.A.1',
                                'name' => 'Direktur Perencanaan dan Pengembangan Bisnis',
                                'level' => 'Direktorat',
                                'directorate_group' => 'Perencanaan dan Pengembangan Bisnis',
                                'children' => [
                                    [
                                        'code' => '1.A.1.1',
                                        'name' => 'Corporate Strategy and Planning',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.A.1.1.1', 'name' => 'Strategy Planning', 'level' => 'Unit'],
                                            ['code' => '1.A.1.1.2', 'name' => 'Portfolio and Performance', 'level' => 'Unit'],
                                            ['code' => '1.A.1.1.3', 'name' => 'Business Analytics and Valuation', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.A.1.2',
                                        'name' => 'Business Development, Partnership and Technology',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.A.1.2.1', 'name' => 'Business Development', 'level' => 'Unit'],
                                            ['code' => '1.A.1.2.2', 'name' => 'Partnership and Ecosystem', 'level' => 'Unit'],
                                            ['code' => '1.A.1.2.3', 'name' => 'Technology and Digital for Business Enablement', 'level' => 'Unit'],
                                        ],
                                    ],
                                    ['code' => '1.A.1.3', 'name' => 'PMO and Transformation', 'level' => 'Unit'],
                                    ['code' => '1.A.1.4', 'name' => 'Research, Innovation and Development', 'level' => 'Unit'],
                                ],
                            ],
                            [
                                'code' => '1.A.2',
                                'name' => 'Direktur SDM',
                                'level' => 'Direktorat',
                                'directorate_group' => 'SDM',
                                'children' => [
                                    [
                                        'code' => '1.A.2.1',
                                        'name' => 'HC Service',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.A.2.1.1', 'name' => 'Talent Acquisition - Human Resources Business', 'level' => 'Unit'],
                                            ['code' => '1.A.2.1.2', 'name' => 'People Development - Talent Management', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.A.2.2',
                                        'name' => 'HC Strategy',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.A.2.2.1', 'name' => 'Compensation and Performance Management', 'level' => 'Unit'],
                                            ['code' => '1.A.2.2.2', 'name' => 'Employee Engagement Management', 'level' => 'Unit'],
                                            ['code' => '1.A.2.2.3', 'name' => 'Hubungan Industrial', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.A.2.3',
                                        'name' => 'HC GA and Operations',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.A.2.3.1', 'name' => 'Personalia', 'level' => 'Unit'],
                                            ['code' => '1.A.2.3.2', 'name' => 'General Affairs', 'level' => 'Unit'],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'code' => '1.A.3',
                                'name' => 'Direktorat Pengadaan dan Logistik',
                                'level' => 'Direktorat',
                                'directorate_group' => 'Pengadaan dan Logistik',
                                'children' => [
                                    [
                                        'code' => '1.A.3.1',
                                        'name' => 'Procurement and Contract Management',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.A.3.1.1', 'name' => 'Strategic Sourcing and Category Management', 'level' => 'Unit'],
                                            ['code' => '1.A.3.1.2', 'name' => 'Procurement Execution', 'level' => 'Unit'],
                                            ['code' => '1.A.3.1.3', 'name' => 'Vendor and Contract Management', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.A.3.2',
                                        'name' => 'Supply Chain and Logistik',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.A.3.2.1', 'name' => 'Supply Planning and Inventory', 'level' => 'Unit'],
                                            ['code' => '1.A.3.2.2', 'name' => 'Logistik and Operation', 'level' => 'Unit'],
                                            ['code' => '1.A.3.2.3', 'name' => 'Warehouse and Distribution', 'level' => 'Unit'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'code' => '1.B',
                        'name' => 'Wakil Direktur Utama II',
                        'level' => 'Wakil Direktur Utama',
                        'children' => [
                            [
                                'code' => '1.B.1',
                                'name' => 'Direktur Business Support',
                                'level' => 'Direktorat',
                                'directorate_group' => 'Business Support',
                                'children' => [
                                    [
                                        'code' => '1.B.1.1',
                                        'name' => 'Corporate - Regional Affairs and Coordination',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.B.1.1.1', 'name' => 'Regional Coordination', 'level' => 'Unit'],
                                            ['code' => '1.B.1.1.2', 'name' => 'Stakeholder and Community Relations', 'level' => 'Unit'],
                                        ],
                                    ],
                                    ['code' => '1.B.1.2', 'name' => 'QSHE Governance and Assurance', 'level' => 'Unit'],
                                    ['code' => '1.B.1.3', 'name' => 'Business Process Improvement', 'level' => 'Unit'],
                                ],
                            ],
                            [
                                'code' => '1.B.2',
                                'name' => 'Direktur Pangan',
                                'level' => 'Direktorat',
                                'directorate_group' => 'Pangan',
                                'is_revenue_center' => true,
                                'is_cost_center' => false,
                                'children' => [
                                    [
                                        'code' => '1.B.2.1',
                                        'name' => 'KSPP',
                                        'level' => 'Sub Direktorat',
                                        'is_revenue_center' => true,
                                        'is_cost_center' => false,
                                        'children' => [
                                            ['code' => '1.B.2.1.1', 'name' => 'KSPP Development', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.2.1.2', 'name' => 'KSPP Operations', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.2.1.3', 'name' => 'KSPP Planning and Operation Control', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.2.2',
                                        'name' => 'Agro Production and Livestock Management',
                                        'level' => 'Sub Direktorat',
                                        'is_revenue_center' => true,
                                        'is_cost_center' => false,
                                        'children' => [
                                            ['code' => '1.B.2.2.1', 'name' => 'Crop Production', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.2.2.2', 'name' => 'Livestock Management', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.2.2.3', 'name' => 'Farmer and Breeder Engagement', 'level' => 'Unit'],
                                            ['code' => '1.B.2.2.4', 'name' => 'Crop and Food Production', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.2.3',
                                        'name' => 'Processing and Food Production',
                                        'level' => 'Sub Direktorat',
                                        'is_revenue_center' => true,
                                        'is_cost_center' => false,
                                        'children' => [
                                            ['code' => '1.B.2.3.1', 'name' => 'Food Processing Crop Based', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.2.3.2', 'name' => 'Dairy and Meat Processing', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.2.3.3', 'name' => 'Facility and Maintenance', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.2.4',
                                        'name' => 'Technical Agribusiness and Land Development',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.B.2.4.1', 'name' => 'Agronomy and Crop System', 'level' => 'Unit'],
                                            ['code' => '1.B.2.4.2', 'name' => 'Livestock System and Nutrition', 'level' => 'Unit'],
                                            ['code' => '1.B.2.4.3', 'name' => 'Land and Topography Development', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'code' => '1.B.3',
                                'name' => 'Direktur Retail dan Distribusi',
                                'level' => 'Direktorat',
                                'directorate_group' => 'Retail dan Distribusi',
                                'is_revenue_center' => true,
                                'is_cost_center' => false,
                                'children' => [
                                    [
                                        'code' => '1.B.3.1',
                                        'name' => 'Retail Performance and Demand Management',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.B.3.1.1', 'name' => 'Demand Planning and Forecast', 'level' => 'Unit'],
                                            ['code' => '1.B.3.1.2', 'name' => 'Replenishment Planning', 'level' => 'Unit'],
                                            ['code' => '1.B.3.1.3', 'name' => 'Retail Performance Analyst', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.3.2',
                                        'name' => 'Distribution and Availability Management',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.B.3.2.1', 'name' => 'Distribution Coordination', 'level' => 'Unit'],
                                            ['code' => '1.B.3.2.2', 'name' => 'Availability and Replenishment Execution', 'level' => 'Unit'],
                                            ['code' => '1.B.3.2.3', 'name' => 'Inventory Control', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.3.3',
                                        'name' => 'Retail Operations',
                                        'level' => 'Sub Direktorat',
                                        'is_revenue_center' => true,
                                        'is_cost_center' => false,
                                        'children' => [
                                            ['code' => '1.B.3.3.1', 'name' => 'KDKMP Operation', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.3.3.2', 'name' => 'Field Operation dan SOP Standard', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.3.4',
                                        'name' => 'Sales and Channel Management',
                                        'level' => 'Sub Direktorat',
                                        'is_revenue_center' => true,
                                        'is_cost_center' => false,
                                        'children' => [
                                            ['code' => '1.B.3.4.1', 'name' => 'Principal and Strategic Account', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.3.4.2', 'name' => 'Ecosystem and UMKM Sourcing', 'level' => 'Unit'],
                                            ['code' => '1.B.3.4.3', 'name' => 'Promotion and Pricing Management', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'code' => '1.B.4',
                                'name' => 'Direktur Keuangan dan Manajemen Risiko',
                                'level' => 'Direktorat',
                                'directorate_group' => 'Keuangan dan Manajemen Risiko',
                                'children' => [
                                    [
                                        'code' => '1.B.4.1',
                                        'name' => 'Keuangan',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.B.4.1.1', 'name' => 'Funding', 'level' => 'Unit'],
                                            ['code' => '1.B.4.1.2', 'name' => 'Treasury', 'level' => 'Unit'],
                                            ['code' => '1.B.4.1.3', 'name' => 'Collection - Corporate', 'level' => 'Unit'],
                                            ['code' => '1.B.4.1.4', 'name' => 'Collection - Retail dan Distribusi', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.4.2',
                                        'name' => 'Akuntansi, Pajak, dan Anggaran',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.B.4.2.1', 'name' => 'Akuntansi', 'level' => 'Unit'],
                                            ['code' => '1.B.4.2.2', 'name' => 'Pajak', 'level' => 'Unit'],
                                            ['code' => '1.B.4.2.3', 'name' => 'Pengendalian Anggaran', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.4.3',
                                        'name' => 'Controller',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.B.4.3.1', 'name' => 'Billing', 'level' => 'Unit'],
                                            ['code' => '1.B.4.3.2', 'name' => 'Pengendalian Biaya - Unit', 'level' => 'Unit'],
                                            ['code' => '1.B.4.3.3', 'name' => 'Revenue Assurance - Pengendalian Biaya Corporate', 'level' => 'Unit'],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.4.4',
                                        'name' => 'Manajemen Risiko dan Kepatuhan',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.B.4.4.1', 'name' => 'Manajemen Risiko', 'level' => 'Unit'],
                                            ['code' => '1.B.4.4.2', 'name' => 'Manajemen Kepatuhan', 'level' => 'Unit'],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'code' => '1.B.5',
                                'name' => 'Direktur Teknik dan Konsultan Enjiniring',
                                'level' => 'Direktorat',
                                'directorate_group' => 'Teknik dan Konsultan Enjiniring',
                                'is_revenue_center' => true,
                                'is_cost_center' => false,
                                'children' => [
                                    [
                                        'code' => '1.B.5.1',
                                        'name' => 'Teknik',
                                        'level' => 'Sub Direktorat',
                                        'is_revenue_center' => true,
                                        'is_cost_center' => false,
                                        'children' => [
                                            ['code' => '1.B.5.1.1', 'name' => 'Design', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.5.1.2', 'name' => 'Perencanaan', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.5.1.3', 'name' => 'Manajemen Konstruksi', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.5.2',
                                        'name' => 'Pemasaran',
                                        'level' => 'Sub Direktorat',
                                        'is_revenue_center' => true,
                                        'is_cost_center' => false,
                                        'children' => [
                                            ['code' => '1.B.5.2.1', 'name' => 'Tender dan Proposal', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.5.2.2', 'name' => 'Customer Relations', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                            ['code' => '1.B.5.2.3', 'name' => 'Kemitraan Strategis dan Market Intelligence', 'level' => 'Unit', 'is_revenue_center' => true, 'is_cost_center' => false],
                                        ],
                                    ],
                                    [
                                        'code' => '1.B.5.3',
                                        'name' => 'Operasional',
                                        'level' => 'Sub Direktorat',
                                        'children' => [
                                            ['code' => '1.B.5.3.1', 'name' => 'Building Management', 'level' => 'Unit'],
                                            ['code' => '1.B.5.3.2', 'name' => 'Engineering', 'level' => 'Unit'],
                                            ['code' => '1.B.5.3.3', 'name' => 'Infrastruktur', 'level' => 'Unit'],
                                            ['code' => '1.B.5.3.4', 'name' => 'Pemukiman dan Pengembangan', 'level' => 'Unit'],
                                            ['code' => '1.B.5.3.5', 'name' => 'Gedung', 'level' => 'Unit'],
                                        ],
                                    ],
                                    ['code' => '1.B.5.4', 'name' => 'Kantor Wilayah', 'level' => 'Unit'],
                                    ['code' => '1.B.5.5', 'name' => 'Production Planning and Control', 'level' => 'Unit'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $sortOrder = 1;

        foreach ($tree as $node) {
            $this->createNode($node, null, 0, '', $sortOrder);
        }
    }

    private function createNode(array $node, ?Organization $parent, int $depth, string $parentPath, int &$sortOrder): Organization
    {
        $path = $parentPath === ''
            ? $node['code']
            : $parentPath . '/' . $node['code'];

        $organization = Organization::query()->updateOrCreate(
            ['code' => $node['code']],
            [
                'parent_id' => $parent?->id,
                'name' => $node['name'],
                'slug' => Str::slug($node['code'] . '-' . $node['name']),
                'depth' => $depth,
                'path' => $path,
                'level' => $node['level'] ?? null,
                'node_type' => $node['node_type'] ?? null,
                'directorate_group' => $node['directorate_group'] ?? $parent?->directorate_group,
                'is_revenue_center' => $node['is_revenue_center'] ?? false,
                'is_cost_center' => $node['is_cost_center'] ?? true,
                'is_active' => true,
                'sort_order' => $sortOrder++,
            ]
        );

        foreach (($node['children'] ?? []) as $child) {
            $this->createNode($child, $organization, $depth + 1, $path, $sortOrder);
        }

        return $organization;
    }
}