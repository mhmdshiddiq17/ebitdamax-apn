import { Head, Link } from '@inertiajs/react';
import { ArrowUpRight } from 'lucide-react';
import CostBreakdownChart from '@/components/dashboard/CostBreakdownChart';
import DashboardFilter from '@/components/dashboard/DashboardFilter';
import DashboardKpiCards from '@/components/dashboard/DashboardKpiCards';
import EbitdaByDirectorateChart from '@/components/dashboard/EbitdaByDirectorateChart';
import MarginRankingChart from '@/components/dashboard/MarginRankingChart';
import NegativeEbitdaAlertTable from '@/components/dashboard/NegativeEbitdaAlertTable';
import RevenueByDirectorateChart from '@/components/dashboard/RevenueByDirectorateChart';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { formatCurrency, formatPercent } from '@/lib/formatters';
import { dashboard } from '@/routes';
import { show as showDirectorate } from '@/routes/dashboard/directorates';
import type { ExecutiveDashboardProps } from '@/types/dashboard';

export default function DashboardIndex({
    year,
    scenario,
    summary,
    directorates,
    charts,
    alerts,
}: ExecutiveDashboardProps) {
    return (
        <>
            <Head title="Dashboard EBITDAMAX APN" />

            <div className="min-h-screen bg-background">
                <div className="space-y-6 p-6">
                    <div className="rounded-lg border bg-card p-6 shadow-sm">
                        <p className="text-sm font-medium tracking-wide text-primary uppercase">
                            Executive Dashboard
                        </p>

                        <h1 className="mt-1 text-2xl font-bold text-foreground">
                            Dashboard EBITDAMAX APN
                        </h1>

                        <p className="mt-2 max-w-4xl text-muted-foreground">
                            Dashboard ini menampilkan Revenue, Cost Breakdown,
                            EBITDA by Directorate, Ranking EBITDA Margin, dan
                            Alert Area Pemborosan Cost berdasarkan hasil import
                            Excel.
                        </p>

                        <div className="mt-4 flex flex-wrap gap-2">
                            <Badge className="bg-primary text-primary-foreground">
                                Tahun {year}
                            </Badge>
                            <Badge
                                variant="outline"
                                className="border-primary/25 bg-primary/5 text-primary"
                            >
                                Scenario: {scenario}
                            </Badge>
                        </div>
                    </div>

                    <DashboardFilter
                        year={year}
                        scenario={scenario}
                        action={dashboard.url()}
                    />

                    <DashboardKpiCards summary={summary} />

                    <div className="grid gap-6 xl:grid-cols-2">
                        <RevenueByDirectorateChart
                            data={charts.revenue_by_directorate}
                        />
                        <CostBreakdownChart data={charts.cost_breakdown} />
                    </div>

                    <div className="grid gap-6 xl:grid-cols-2">
                        <EbitdaByDirectorateChart
                            data={charts.ebitda_by_directorate}
                        />
                        <MarginRankingChart data={charts.margin_ranking} />
                    </div>

                    <NegativeEbitdaAlertTable data={alerts.negative_ebitda} />

                    <Card className="border bg-card shadow-sm">
                        <CardHeader>
                            <CardTitle className="text-foreground">
                                Dashboard per Unit Organisasi
                            </CardTitle>
                        </CardHeader>

                        <CardContent>
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm">
                                    <thead>
                                        <tr className="border-b bg-muted/40 text-left text-muted-foreground">
                                            <th className="p-3">Kode</th>
                                            <th className="p-3">
                                                Unit Organisasi
                                            </th>
                                            <th className="p-3 text-right">
                                                Revenue
                                            </th>
                                            <th className="p-3 text-right">
                                                TOC
                                            </th>
                                            <th className="p-3 text-right">
                                                EBITDA
                                            </th>
                                            <th className="p-3 text-right">
                                                Margin
                                            </th>
                                            <th className="p-3 text-right">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        {directorates.map((item) => (
                                            <tr
                                                key={item.id}
                                                className="border-b transition-colors hover:bg-muted/40"
                                            >
                                                <td className="p-3">
                                                    <Badge className="bg-primary text-primary-foreground">
                                                        {item.code}
                                                    </Badge>
                                                </td>

                                                <td className="p-3">
                                                    <div className="font-medium text-foreground">
                                                        {item.name}
                                                    </div>
                                                    <div className="text-xs text-muted-foreground">
                                                        {item.is_revenue_center
                                                            ? 'Revenue Center'
                                                            : 'Cost Center'}
                                                    </div>
                                                </td>

                                                <td className="p-3 text-right">
                                                    {formatCurrency(
                                                        item.value.revenue,
                                                    )}
                                                </td>

                                                <td className="p-3 text-right">
                                                    {formatCurrency(
                                                        item.value.toc,
                                                    )}
                                                </td>

                                                <td
                                                    className={`p-3 text-right font-semibold ${
                                                        item.value.ebitda < 0
                                                            ? 'text-destructive'
                                                            : 'text-primary'
                                                    }`}
                                                >
                                                    {formatCurrency(
                                                        item.value.ebitda,
                                                    )}
                                                </td>

                                                <td className="p-3 text-right">
                                                    {formatPercent(
                                                        item.value
                                                            .ebitda_margin,
                                                    )}
                                                </td>

                                                <td className="p-3 text-right">
                                                    <Button asChild size="sm">
                                                        <Link
                                                            href={showDirectorate(
                                                                item.slug,
                                                            )}
                                                        >
                                                            Detail{' '}
                                                            <ArrowUpRight className="ml-1 h-4 w-4" />
                                                        </Link>
                                                    </Button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </>
    );
}

DashboardIndex.layout = {
    surface: 'financial-light',
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
    ],
};
