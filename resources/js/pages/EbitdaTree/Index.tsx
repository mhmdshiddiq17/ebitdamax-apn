import { Head, router } from '@inertiajs/react';
import { useState } from 'react';
import type { FormEvent } from 'react';
import EbitdaTreeFlow from '@/components/ebitda-tree/EbitdaTreeFlow';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { index as ebitdaTreeIndex } from '@/routes/ebitda-tree';
import type { EbitdaTreeNode, EbitdaTreeOption } from '@/types/ebitda-tree';

type Props = {
    year: number;
    scenario: string;
    selectedRoot: string;
    treeOptions: EbitdaTreeOption[];
    tree: EbitdaTreeNode;
};

const scenarios = [
    { value: 'target_tahunan', label: 'Target Tahunan' },
    { value: 'target_harian', label: 'Target Harian' },
    { value: 'plan_harian', label: 'Plan Harian' },
    { value: 'aktual_harian', label: 'Aktual Harian' },
];

export default function EbitdaTreeIndex({
    year,
    scenario,
    selectedRoot,
    treeOptions,
    tree,
}: Props) {
    const [form, setForm] = useState({
        year,
        scenario,
        root: selectedRoot,
    });

    const submit = (event: FormEvent) => {
        event.preventDefault();

        router.get(
            ebitdaTreeIndex.url(),
            {
                year: form.year,
                scenario: form.scenario,
                root: form.root,
            },
            {
                preserveState: true,
                preserveScroll: true,
            },
        );
    };

    return (
        <>
            <Head title="Pohon EBITDA" />

            <div className="min-h-screen bg-background">
                <div className="space-y-6 p-6">
                    <div className="rounded-lg border bg-card p-6 shadow-sm">
                        <p className="text-sm font-medium tracking-wide text-primary uppercase">
                            Sprint 4 — EBITDA Tree Visualization
                        </p>

                        <h1 className="mt-1 text-2xl font-bold text-foreground">
                            Dashboard Pohon EBITDA
                        </h1>

                        <p className="mt-2 max-w-3xl text-muted-foreground">
                            Visualisasi struktur organisasi dan nilai EBITDA
                            dari hasil import Excel. Setiap node menampilkan
                            Revenue, DOC-V, DOC-F, IOC, TOC, EBITDA, dan EBITDA
                            Margin sesuai scenario yang dipilih.
                        </p>
                    </div>

                    <Card className="border bg-card shadow-sm">
                        <CardContent className="p-5">
                            <form
                                onSubmit={submit}
                                className="grid gap-4 md:grid-cols-4"
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
                                                year: Number(
                                                    event.target.value,
                                                ),
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
                                            <option
                                                key={item.value}
                                                value={item.value}
                                            >
                                                {item.label}
                                            </option>
                                        ))}
                                    </select>
                                </div>

                                <div className="space-y-2">
                                    <label className="text-sm font-medium text-foreground">
                                        Root Tree
                                    </label>
                                    <select
                                        value={form.root}
                                        onChange={(event) =>
                                            setForm((current) => ({
                                                ...current,
                                                root: event.target.value,
                                            }))
                                        }
                                        className="h-10 w-full rounded-md border border-input bg-background px-3 text-sm text-foreground transition-colors outline-none focus:border-ring focus:ring-2 focus:ring-ring/40"
                                    >
                                        {treeOptions.map((item) => (
                                            <option
                                                key={item.id}
                                                value={item.slug}
                                            >
                                                {item.code} — {item.name}
                                            </option>
                                        ))}
                                    </select>
                                </div>

                                <div className="flex items-end">
                                    <Button type="submit" className="w-full">
                                        Terapkan Filter
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>

                    <EbitdaTreeFlow tree={tree} />
                </div>
            </div>
        </>
    );
}

EbitdaTreeIndex.layout = {
    surface: 'financial-light',
    breadcrumbs: [
        {
            title: 'Pohon EBITDA',
            href: ebitdaTreeIndex(),
        },
    ],
};
