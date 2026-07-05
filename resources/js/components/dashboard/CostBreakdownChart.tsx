import { Cell, Pie, PieChart, ResponsiveContainer, Tooltip } from 'recharts';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import type { ChartItem } from '@/types/dashboard';
import { chartCurrency, costColors } from './chart-utils';

type Props = {
    data: ChartItem[];
};

export default function CostBreakdownChart({ data }: Props) {
    const total = data.reduce((sum, item) => sum + item.value, 0);

    return (
        <Card className="border bg-card shadow-sm">
            <CardHeader>
                <CardTitle className="text-foreground">
                    Cost Breakdown
                </CardTitle>
            </CardHeader>

            <CardContent className="grid gap-4 md:grid-cols-[1fr_220px]">
                <div className="h-[320px]">
                    <ResponsiveContainer width="100%" height="100%">
                        <PieChart>
                            <Pie
                                data={data}
                                dataKey="value"
                                nameKey="name"
                                innerRadius={72}
                                outerRadius={118}
                                paddingAngle={4}
                            >
                                {data.map((_, index) => (
                                    <Cell
                                        key={index}
                                        fill={
                                            costColors[
                                                index % costColors.length
                                            ]
                                        }
                                    />
                                ))}
                            </Pie>
                            <Tooltip
                                contentStyle={{
                                    backgroundColor: 'var(--card)',
                                    border: '1px solid var(--border)',
                                    borderRadius: 8,
                                    color: 'var(--card-foreground)',
                                }}
                                itemStyle={{ color: 'var(--card-foreground)' }}
                                formatter={(value) => [
                                    `Rp ${chartCurrency(Number(value))}`,
                                    'Cost',
                                ]}
                            />
                        </PieChart>
                    </ResponsiveContainer>
                </div>

                <div className="space-y-3 self-center">
                    {data.map((item, index) => {
                        const percentage =
                            total > 0 ? (item.value / total) * 100 : 0;

                        return (
                            <div
                                key={item.name}
                                className="rounded-xl border bg-background p-3"
                            >
                                <div className="flex items-center justify-between gap-3">
                                    <div className="flex items-center gap-2">
                                        <span
                                            className="h-3 w-3 rounded-full"
                                            style={{
                                                backgroundColor:
                                                    costColors[
                                                        index %
                                                            costColors.length
                                                    ],
                                            }}
                                        />
                                        <span className="text-sm font-medium">
                                            {item.name}
                                        </span>
                                    </div>
                                    <span className="text-sm font-bold text-primary">
                                        {percentage.toFixed(1)}%
                                    </span>
                                </div>

                                <p className="mt-1 text-xs text-muted-foreground">
                                    Rp {chartCurrency(item.value)}
                                </p>
                            </div>
                        );
                    })}
                </div>
            </CardContent>
        </Card>
    );
}
