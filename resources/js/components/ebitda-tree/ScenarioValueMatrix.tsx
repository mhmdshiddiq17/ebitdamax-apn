import { formatCompactCurrency, formatPercent } from '@/lib/formatters';
import { cn } from '@/lib/utils';
import type {
    EbitdaDirectValueSource,
    EbitdaScenarioKey,
    EbitdaScenarioValues,
    EbitdaValue,
} from '@/types/ebitda-tree';

type Props = {
    scenarioValues?: EbitdaScenarioValues;
    fallbackValue: EbitdaValue;
    showDirectValueColumn?: boolean;
    directValueSource?: EbitdaDirectValueSource;
    directValue?: EbitdaValue;
    className?: string;
};

type MetricKey = keyof Pick<
    EbitdaValue,
    | 'revenue'
    | 'doc_variable'
    | 'doc_fixed'
    | 'ioc'
    | 'toc'
    | 'ebitda'
    | 'ebitda_margin'
>;

const scenarios: Array<{ key: EbitdaScenarioKey; label: string }> = [
    { key: 'target_tahunan', label: 'Target Tahunan' },
    { key: 'target_harian', label: 'Target Harian' },
    { key: 'plan_harian', label: 'Plan Harian' },
    { key: 'aktual_harian', label: 'Aktual Harian' },
];

const metrics: Array<{ key: MetricKey; label: string }> = [
    { key: 'revenue', label: 'Revenue' },
    { key: 'doc_variable', label: 'DOC-V' },
    { key: 'doc_fixed', label: 'DOC-F' },
    { key: 'ioc', label: 'IOC' },
    { key: 'toc', label: 'TOC' },
    { key: 'ebitda', label: 'EBITDA' },
    { key: 'ebitda_margin', label: 'Margin' },
];

function valueForScenario(
    scenarioValues: EbitdaScenarioValues | undefined,
    scenario: EbitdaScenarioKey,
    fallbackValue: EbitdaValue,
): EbitdaValue {
    return scenarioValues?.[scenario]?.value ?? fallbackValue;
}

function formatMetricValue(value: EbitdaValue, metric: MetricKey): string {
    if (metric === 'ebitda_margin') {
        return formatPercent(value.ebitda_margin);
    }

    return formatCompactCurrency(value[metric]);
}

export default function ScenarioValueMatrix({
    scenarioValues,
    fallbackValue,
    showDirectValueColumn = false,
    directValueSource = 'empty',
    directValue,
    className,
}: Props) {
    const visibleDirectValue = directValue ?? fallbackValue;

    return (
        <div
            className={cn(
                'overflow-hidden rounded-lg border bg-background text-[10px]',
                className,
            )}
        >
            <table className="w-full table-fixed border-collapse">
                <thead>
                    <tr className="border-b bg-muted/70">
                        <th className="w-[82px] px-2 py-2 text-left font-semibold text-muted-foreground">
                            Metrik
                        </th>
                        {showDirectValueColumn && (
                            <th className="border-x border-emerald-500/25 bg-emerald-500/10 px-1.5 py-2 text-right font-semibold text-foreground">
                                Nilai Input
                            </th>
                        )}
                        {scenarios.map((scenario) => (
                            <th
                                key={scenario.key}
                                className="px-1.5 py-2 text-right font-semibold text-foreground"
                            >
                                {scenario.label}
                            </th>
                        ))}
                    </tr>
                </thead>

                <tbody>
                    {metrics.map((metric) => (
                        <tr key={metric.key} className="border-b last:border-0">
                            <th className="bg-muted/30 px-2 py-1.5 text-left font-medium text-muted-foreground">
                                {metric.label}
                            </th>
                            {showDirectValueColumn && (
                                <td
                                    className={cn(
                                        'border-x border-emerald-500/25 bg-emerald-500/5 px-1.5 py-1.5 text-right font-semibold text-foreground tabular-nums',
                                        directValueSource === 'empty' &&
                                            'text-muted-foreground',
                                        metric.key === 'ebitda' &&
                                            visibleDirectValue.ebitda < 0 &&
                                            'text-destructive',
                                    )}
                                >
                                    {formatMetricValue(
                                        visibleDirectValue,
                                        metric.key,
                                    )}
                                </td>
                            )}
                            {scenarios.map((scenario) => {
                                const scenarioValue = valueForScenario(
                                    scenarioValues,
                                    scenario.key,
                                    fallbackValue,
                                );
                                const isNegativeEbitda =
                                    metric.key === 'ebitda' &&
                                    scenarioValue.ebitda < 0;

                                return (
                                    <td
                                        key={scenario.key}
                                        className={cn(
                                            'px-1.5 py-1.5 text-right font-semibold text-foreground tabular-nums',
                                            isNegativeEbitda &&
                                                'text-destructive',
                                        )}
                                    >
                                        {formatMetricValue(
                                            scenarioValue,
                                            metric.key,
                                        )}
                                    </td>
                                );
                            })}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
