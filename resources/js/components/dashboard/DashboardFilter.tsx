import { router } from '@inertiajs/react';
import type { FormEvent } from 'react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';

type Props = {
    year: number;
    action: string;
};

export default function DashboardFilter({ year, action }: Props) {
    const [form, setForm] = useState({
        year,
    });

    const submit = (event: FormEvent) => {
        event.preventDefault();

        router.get(
            action,
            {
                year: form.year,
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
            className="grid gap-4 rounded-lg border bg-card p-5 shadow-sm md:grid-cols-[1fr_auto]"
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

            <div className="flex items-end">
                <Button className="w-full">Terapkan Filter</Button>
            </div>
        </form>
    );
}
