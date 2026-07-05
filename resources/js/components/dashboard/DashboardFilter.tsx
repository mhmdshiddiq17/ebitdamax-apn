import { router } from '@inertiajs/react';
import type { FormEvent } from 'react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';

type Props = {
    year: number;
    scenario: string;
    action: string;
};

const scenarios = [
    { value: 'target_tahunan', label: 'Target Tahunan' },
    { value: 'target_harian', label: 'Target Harian' },
    { value: 'plan_harian', label: 'Plan Harian' },
    { value: 'aktual_harian', label: 'Aktual Harian' },
];

export default function DashboardFilter({ year, scenario, action }: Props) {
    const [form, setForm] = useState({
        year,
        scenario,
    });

    const submit = (event: FormEvent) => {
        event.preventDefault();

        router.get(
            action,
            {
                year: form.year,
                scenario: form.scenario,
            },
            {
                preserveScroll: true,
                preserveState: true,
            },
        );
    };

    return (
        <form
            onSubmit={submit}
            className="grid gap-4 rounded-lg border bg-card p-5 shadow-sm md:grid-cols-[1fr_1fr_auto]"
        >
            <div className="space-y-2">
                <label className="text-sm font-medium text-foreground">
                    Tahun
                </label>
                <input
                    type="number"
                    value={form.year}
                    onChange={(event) =>
                        setForm((current) => ({
                            ...current,
                            year: Number(event.target.value),
                        }))
                    }
                    className="h-10 w-full rounded-md border border-input bg-background px-3 text-sm text-foreground transition-colors outline-none focus:border-ring focus:ring-2 focus:ring-ring/40"
                />
            </div>

            <div className="space-y-2">
                <label className="text-sm font-medium text-foreground">
                    Scenario
                </label>
                <select
                    value={form.scenario}
                    onChange={(event) =>
                        setForm((current) => ({
                            ...current,
                            scenario: event.target.value,
                        }))
                    }
                    className="h-10 w-full rounded-md border border-input bg-background px-3 text-sm text-foreground transition-colors outline-none focus:border-ring focus:ring-2 focus:ring-ring/40"
                >
                    {scenarios.map((item) => (
                        <option key={item.value} value={item.value}>
                            {item.label}
                        </option>
                    ))}
                </select>
            </div>

            <div className="flex items-end">
                <Button className="w-full">Terapkan Filter</Button>
            </div>
        </form>
    );
}
