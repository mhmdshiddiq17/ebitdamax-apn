import {
    Bar,
    BarChart,
    CartesianGrid,
    ResponsiveContainer,
    Tooltip,
    XAxis,
    YAxis,
} from 'recharts';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import type { ChartItem } from '@/types/dashboard';
import { chartCurrency, chartRed } from './chart-utils';

type Props = {
    data: ChartItem[];
};

export default function RevenueByDirectorateChart({ data }: Props) {
    return (
        <Card className="border bg-card shadow-sm">
            <CardHeader>
                <CardTitle className="text-foreground">
                    Revenue by Directorate
                </CardTitle>
            </CardHeader>

            <CardContent className="h-[360px]">
                <ResponsiveContainer width="100%" height="100%">
                    <BarChart
                        data={data}
                        layout="vertical"
                        margin={{ left: 24, right: 24 }}
                    >
                        <CartesianGrid
                            strokeDasharray="3 3"
                            horizontal={false}
                            stroke="var(--border)"
                        />
                        <XAxis
                            type="number"
                            tick={{ fill: 'var(--muted-foreground)' }}
                            tickFormatter={(value) =>
                                chartCurrency(Number(value))
                            }
                        />
                        <YAxis
                            type="category"
                            dataKey="label"
                            width={72}
                            tick={{ fill: 'var(--muted-foreground)' }}
                        />
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
                                'Revenue',
                            ]}
                            labelFormatter={(_, payload) =>
                                payload?.[0]?.payload?.name ?? ''
                            }
                        />
                        <Bar
                            dataKey="value"
                            fill={chartRed}
                            radius={[0, 8, 8, 0]}
                            maxBarSize={32}
                        />
                    </BarChart>
                </ResponsiveContainer>
            </CardContent>
        </Card>
    );
}
