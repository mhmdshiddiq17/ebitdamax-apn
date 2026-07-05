import { Handle, Position } from '@xyflow/react';
import type { Node, NodeProps } from '@xyflow/react';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent } from '@/components/ui/card';
import { formatCompactCurrency, formatPercent } from '@/lib/formatters';
import type { EbitdaTreeNode } from '@/types/ebitda-tree';

export type EbitdaFlowNode = Node<EbitdaTreeNode, 'ebitdaNode'>;

export default function EbitdaNodeCard({ data }: NodeProps<EbitdaFlowNode>) {
    const isNegative = data.value.ebitda < 0;
    const isRevenueCenter = data.is_revenue_center;

    return (
        <Card
            className={`w-[360px] border-2 bg-card shadow-md transition hover:shadow-lg ${
                isNegative ? 'border-destructive/50' : 'border-border'
            }`}
        >
            <Handle
                type="target"
                position={Position.Top}
                className="!h-3 !w-3 !border-2 !border-card !bg-primary"
            />

            <CardContent className="space-y-3 p-4">
                <div className="flex flex-wrap items-center gap-2">
                    <Badge className="bg-primary text-primary-foreground hover:bg-primary/90">
                        {data.code}
                    </Badge>

                    {data.level && (
                        <Badge
                            variant="outline"
                            className="border-primary/25 bg-primary/5 text-primary"
                        >
                            {data.level}
                        </Badge>
                    )}

                    <Badge
                        className={
                            isRevenueCenter
                                ? 'bg-primary text-primary-foreground hover:bg-primary/90'
                                : 'bg-primary/10 text-primary hover:bg-primary/15'
                        }
                    >
                        {isRevenueCenter ? 'Revenue Center' : 'Cost Center'}
                    </Badge>
                </div>

                <div>
                    <h3 className="line-clamp-2 text-sm leading-snug font-bold text-foreground">
                        {data.name}
                    </h3>

                    <p className="mt-1 text-xs text-muted-foreground">
                        Source:{' '}
                        {data.value_source === 'excel'
                            ? 'Excel'
                            : data.value_source === 'calculated_from_children'
                              ? 'Agregasi child'
                              : 'Belum ada data'}
                    </p>
                </div>

                <div className="grid grid-cols-2 gap-2 text-xs">
                    <div className="rounded-lg bg-muted p-2">
                        <p className="text-muted-foreground">Revenue</p>
                        <p className="font-semibold text-foreground">
                            {formatCompactCurrency(data.value.revenue)}
                        </p>
                    </div>

                    <div className="rounded-lg bg-muted p-2">
                        <p className="text-muted-foreground">TOC</p>
                        <p className="font-semibold text-foreground">
                            {formatCompactCurrency(data.value.toc)}
                        </p>
                    </div>

                    <div className="rounded-lg bg-background p-2 ring-1 ring-border">
                        <p className="text-muted-foreground">DOC-V</p>
                        <p className="font-semibold text-foreground">
                            {formatCompactCurrency(data.value.doc_variable)}
                        </p>
                    </div>

                    <div className="rounded-lg bg-background p-2 ring-1 ring-border">
                        <p className="text-muted-foreground">DOC-F</p>
                        <p className="font-semibold text-foreground">
                            {formatCompactCurrency(data.value.doc_fixed)}
                        </p>
                    </div>

                    <div className="rounded-lg bg-background p-2 ring-1 ring-border">
                        <p className="text-muted-foreground">IOC</p>
                        <p className="font-semibold text-foreground">
                            {formatCompactCurrency(data.value.ioc)}
                        </p>
                    </div>

                    <div className="rounded-lg bg-background p-2 ring-1 ring-border">
                        <p className="text-muted-foreground">Margin</p>
                        <p className="font-semibold text-foreground">
                            {formatPercent(data.value.ebitda_margin)}
                        </p>
                    </div>
                </div>

                <div className="rounded-xl border bg-background p-3">
                    <p className="text-xs text-muted-foreground">EBITDA</p>
                    <p
                        className={`text-lg font-bold ${
                            isNegative ? 'text-destructive' : 'text-primary'
                        }`}
                    >
                        {formatCompactCurrency(data.value.ebitda)}
                    </p>
                </div>
            </CardContent>

            <Handle
                type="source"
                position={Position.Bottom}
                className="!h-3 !w-3 !border-2 !border-card !bg-primary"
            />
        </Card>
    );
}
