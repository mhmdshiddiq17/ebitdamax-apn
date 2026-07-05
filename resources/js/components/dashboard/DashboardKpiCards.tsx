import {
    CircleDollarSign,
    Landmark,
    TrendingDown,
    TrendingUp,
} from 'lucide-react';
import { Card, CardContent } from '@/components/ui/card';
import { formatCurrency, formatPercent } from '@/lib/formatters';
import type { EbitdaValue } from '@/types/ebitda-tree';

type Props = {
    summary: EbitdaValue;
};

function KpiCard({
    title,
    value,
    icon: Icon,
    danger = false,
}: {
    title: string;
    value: string;
    icon: React.ElementType;
    danger?: boolean;
}) {
    return (
        <Card className="border bg-card shadow-sm">
            <CardContent className="flex items-center justify-between p-5">
                <div>
                    <p className="text-sm text-muted-foreground">{title}</p>
                    <p
                        className={`mt-1 text-xl font-bold ${danger ? 'text-destructive' : 'text-primary'}`}
                    >
                        {value}
                    </p>
                </div>
                <div className="rounded-full bg-primary/10 p-3 text-primary">
                    <Icon className="h-5 w-5" />
                </div>
            </CardContent>
        </Card>
    );
}

export default function DashboardKpiCards({ summary }: Props) {
    return (
        <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <KpiCard
                title="Total Revenue"
                value={formatCurrency(summary.revenue)}
                icon={CircleDollarSign}
            />

            <KpiCard
                title="Total Cost / TOC"
                value={formatCurrency(summary.toc)}
                icon={Landmark}
            />

            <KpiCard
                title="EBITDA"
                value={formatCurrency(summary.ebitda)}
                icon={summary.ebitda < 0 ? TrendingDown : TrendingUp}
                danger={summary.ebitda < 0}
            />

            <KpiCard
                title="EBITDA Margin"
                value={formatPercent(summary.ebitda_margin)}
                icon={TrendingUp}
                danger={(summary.ebitda_margin ?? 0) < 0}
            />
        </div>
    );
}
