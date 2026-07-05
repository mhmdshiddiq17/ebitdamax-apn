import {
    Bar,
    BarChart,
    CartesianGrid,
    Cell,
    ResponsiveContainer,
    Tooltip,
    XAxis,
    YAxis,
} from 'recharts';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import type { ChartItem } from '@/types/dashboard';
import { chartCurrency, chartDarkRed, chartRed } from './chart-utils';

type Props = {
    data: ChartItem[];
};

export default function EbitdaByDirectorateChart({ data }: Props) {
    return (
        <Card className="border bg-card shadow-sm">
            <CardHeader>
                <CardTitle className="text-foreground">
                    EBITDA by Directorate
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
                                'EBITDA',
                            ]}
                            labelFormatter={(_, payload) =>
                                payload?.[0]?.payload?.name ?? ''
                            }
                        />
                        <Bar
                            dataKey="value"
                            radius={[0, 8, 8, 0]}
                            maxBarSize={32}
                        >
                            {data.map((item) => (
                                <Cell
                                    key={item.label}
                                    fill={
                                        item.value < 0 ? chartDarkRed : chartRed
                                    }
                                />
                            ))}
                        </Bar>
                    </BarChart>
                </ResponsiveContainer>
            </CardContent>
        </Card>
    );
}
