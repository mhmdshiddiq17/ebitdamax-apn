import { Head, Link } from '@inertiajs/react';
import { AlertTriangle, ArrowLeft } from 'lucide-react';
import CostBreakdownChart from '@/components/dashboard/CostBreakdownChart';
import DashboardFilter from '@/components/dashboard/DashboardFilter';
import DashboardKpiCards from '@/components/dashboard/DashboardKpiCards';
import EbitdaByDirectorateChart from '@/components/dashboard/EbitdaByDirectorateChart';
import MarginRankingChart from '@/components/dashboard/MarginRankingChart';
import NegativeEbitdaAlertTable from '@/components/dashboard/NegativeEbitdaAlertTable';
import RevenueByDirectorateChart from '@/components/dashboard/RevenueByDirectorateChart';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { formatCurrency, formatPercent } from '@/lib/formatters';
import { cn } from '@/lib/utils';
import { dashboard } from '@/routes';
import { show as showDirectorate } from '@/routes/dashboard/directorates';
import type { DirectorateDashboardProps } from '@/types/dashboard';
import type { EbitdaTreeNode } from '@/types/ebitda-tree';

function CostValueCell({
    node,
    field,
}: {
    node: EbitdaTreeNode;
    field: 'doc_variable' | 'doc_fixed' | 'ioc';
}) {
    const isOverrun = node.cost_alert.components.some(
        (component) => component.key === field,
    );

    return (
        <td
            className={cn(
                'p-3 text-right',
                isOverrun && 'bg-destructive/5 font-bold text-destructive',
            )}
        >
            {formatCurrency(node.value[field])}
        </td>
    );
}

function TreeRow({
    node,
    depth = 0,
}: {
    node: EbitdaTreeNode;
    depth?: number;
}) {
    return (
        <>
            <tr
                className={cn(
                    'border-b transition-colors hover:bg-muted/40',
                    node.cost_alert.has_overrun &&
                        'bg-destructive/5 hover:bg-destructive/10',
                )}
            >
                <td
                    className="p-3"
                    style={{ paddingLeft: `${12 + depth * 24}px` }}
                >
                    <div className="flex items-center gap-2">
                        <Badge className="bg-primary text-primary-foreground">
                            {node.code}
                        </Badge>
                        {node.cost_alert.has_overrun && (
                            <Badge
                                className={cn(
                                    'gap-1 text-white',
                                    node.cost_alert.severity === 'danger'
                                        ? 'bg-black hover:bg-black/90'
                                        : 'bg-destructive hover:bg-destructive/90',
                                )}
                            >
                                <AlertTriangle className="size-3" />
                                Area pemborosan
                            </Badge>
                        )}
                        <span className="font-medium text-foreground">
                            {node.name}
                        </span>
                    </div>
                    <div className="mt-1 text-xs text-muted-foreground">
                        {node.level ?? '-'} •{' '}
                        {node.is_revenue_center
                            ? 'Revenue Center'
                            : 'Cost Center'}
                    </div>
                </td>

                <td className="p-3 text-right">
                    {formatCurrency(node.value.revenue)}
                </td>
                <CostValueCell node={node} field="doc_variable" />
                <CostValueCell node={node} field="doc_fixed" />
                <CostValueCell node={node} field="ioc" />
                <td className="p-3 text-right">
                    {formatCurrency(node.value.toc)}
                </td>

                <td
                    className={`p-3 text-right font-semibold ${
                        node.value.ebitda < 0
                            ? 'text-destructive'
                            : 'text-primary'
                    }`}
                >
                    {formatCurrency(node.value.ebitda)}
                </td>

                <td className="p-3 text-right">
                    {formatPercent(node.value.ebitda_margin)}
                </td>
            </tr>

            {node.children.map((child) => (
                <TreeRow key={child.id} node={child} depth={depth + 1} />
            ))}
        </>
    );
}

export default function DirectorateDashboard({
    year,
    scenario,
    directorate,
    summary,
    tree,
    charts,
    alerts,
}: DirectorateDashboardProps) {
    return (
        <>
            <Head title={`Dashboard ${directorate.name}`} />

            <div className="min-h-screen bg-background">
                <div className="space-y-6 p-6">
                    <div className="rounded-lg border bg-card p-6 shadow-sm">
                        <Link
                            href={dashboard()}
                            className="inline-flex items-center gap-2 text-sm font-medium text-primary hover:text-primary/80"
                        >
                            <ArrowLeft className="h-4 w-4" />
                            Kembali ke Dashboard Utama
                        </Link>

                        <div className="mt-4">
                            <p className="text-sm font-medium tracking-wide text-primary uppercase">
                                Dashboard Direktorat
                            </p>

                            <h1 className="mt-1 text-2xl font-bold text-foreground">
                                {directorate.name}
                            </h1>

                            <div className="mt-3 flex flex-wrap gap-2">
                                <Badge className="bg-primary text-primary-foreground">
                                    {directorate.code}
                                </Badge>
                                <Badge
                                    variant="outline"
                                    className="border-primary/25 bg-primary/5 text-primary"
                                >
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
                    </div>

                    <DashboardFilter
                        year={year}
                        scenario={scenario}
                        action={showDirectorate.url(directorate.slug)}
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
                                Breakdown Pohon EBITDA Direktorat
                            </CardTitle>
                        </CardHeader>

                        <CardContent>
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm">
                                    <thead>
                                        <tr className="border-b bg-muted/40 text-left text-muted-foreground">
                                            <th className="p-3">Unit</th>
                                            <th className="p-3 text-right">
                                                Revenue
                                            </th>
                                            <th className="p-3 text-right">
                                                DOC-V
                                            </th>
                                            <th className="p-3 text-right">
                                                DOC-F
                                            </th>
                                            <th className="p-3 text-right">
                                                IOC
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
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <TreeRow node={tree} />
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

DirectorateDashboard.layout = ({ directorate }: DirectorateDashboardProps) => ({
    surface: 'financial-light',
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
        {
            title: directorate.name,
            href: showDirectorate(directorate.slug),
        },
    ],
});
