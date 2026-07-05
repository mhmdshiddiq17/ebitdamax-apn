import { AlertTriangle } from 'lucide-react';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { formatCurrency, formatPercent } from '@/lib/formatters';
import type { NegativeEbitdaAlert } from '@/types/dashboard';

type Props = {
    data: NegativeEbitdaAlert[];
};

export default function NegativeEbitdaAlertTable({ data }: Props) {
    return (
        <Card className="border bg-card shadow-sm">
            <CardHeader>
                <CardTitle className="flex items-center gap-2 text-destructive">
                    <AlertTriangle className="h-5 w-5" />
                    Alert EBITDA Negatif
                </CardTitle>
            </CardHeader>

            <CardContent>
                <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                        <thead>
                            <tr className="border-b bg-muted/40 text-left text-muted-foreground">
                                <th className="p-3">Unit</th>
                                <th className="p-3 text-right">Revenue</th>
                                <th className="p-3 text-right">TOC</th>
                                <th className="p-3 text-right">EBITDA</th>
                                <th className="p-3 text-right">Margin</th>
                                <th className="p-3">Analisis Awal</th>
                            </tr>
                        </thead>

                        <tbody>
                            {data.map((item) => (
                                <tr
                                    key={`${item.organization_id}-${item.code}`}
                                    className="border-b transition-colors hover:bg-muted/40"
                                >
                                    <td className="p-3">
                                        <div className="flex flex-wrap items-center gap-2">
                                            <Badge className="bg-primary text-primary-foreground">
                                                {item.code ?? '-'}
                                            </Badge>
                                            {item.level && (
                                                <Badge
                                                    variant="outline"
                                                    className="border-primary/25 bg-primary/5 text-primary"
                                                >
                                                    {item.level}
                                                </Badge>
                                            )}
                                        </div>
                                        <div className="mt-1 font-medium text-foreground">
                                            {item.name ?? '-'}
                                        </div>
                                    </td>

                                    <td className="p-3 text-right">
                                        {formatCurrency(item.revenue)}
                                    </td>

                                    <td className="p-3 text-right">
                                        {formatCurrency(item.toc)}
                                    </td>

                                    <td className="p-3 text-right font-bold text-destructive">
                                        {formatCurrency(item.ebitda)}
                                    </td>

                                    <td className="p-3 text-right">
                                        {formatPercent(item.ebitda_margin)}
                                    </td>

                                    <td className="p-3 text-sm text-muted-foreground">
                                        {item.revenue <= 0
                                            ? 'Cost center / belum ada revenue. Fokus kontrol TOC, DOC-F, dan IOC.'
                                            : 'Revenue belum mampu menutup total cost. Evaluasi pricing, volume, dan cost structure.'}
                                    </td>
                                </tr>
                            ))}

                            {data.length === 0 && (
                                <tr>
                                    <td
                                        colSpan={6}
                                        className="p-8 text-center text-muted-foreground"
                                    >
                                        Tidak ada unit dengan EBITDA negatif
                                        pada scenario ini.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </CardContent>
        </Card>
    );
}
