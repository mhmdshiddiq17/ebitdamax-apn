import { Head } from '@inertiajs/react';
import { Building2, CircleDot, Network, ShieldCheck } from 'lucide-react';
import type { ElementType } from 'react';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { index as organizationsIndex } from '@/routes/organizations';
import type {
    OrganizationNode,
    OrganizationSummary,
} from '@/types/organization';

type Props = {
    organizations: OrganizationNode[];
    summary: OrganizationSummary;
};

function StatCard({
    title,
    value,
    icon: Icon,
}: {
    title: string;
    value: number | string;
    icon: ElementType;
}) {
    return (
        <Card className="rounded-lg border bg-card shadow-sm">
            <CardContent className="flex items-center justify-between gap-4 p-5">
                <div>
                    <p className="text-sm text-muted-foreground">{title}</p>
                    <p className="mt-1 text-2xl font-semibold text-primary">
                        {value}
                    </p>
                </div>
                <div className="rounded-lg bg-primary/10 p-3 text-primary">
                    <Icon className="size-5" />
                </div>
            </CardContent>
        </Card>
    );
}

function OrganizationTreeItem({ node }: { node: OrganizationNode }) {
    const hasChildren = node.children.length > 0;

    return (
        <div className="relative pl-5">
            <div className="absolute top-0 left-0 h-full border-l border-border" />

            <div className="mb-3 rounded-lg border bg-card p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div className="flex flex-wrap items-start justify-between gap-3">
                    <div className="space-y-1">
                        <div className="flex flex-wrap items-center gap-2">
                            <Badge className="bg-primary text-primary-foreground hover:bg-primary/90">
                                {node.code}
                            </Badge>

                            {node.level && (
                                <Badge
                                    variant="outline"
                                    className="border-primary/25 bg-primary/5 text-primary"
                                >
                                    {node.level}
                                </Badge>
                            )}

                            {node.is_revenue_center ? (
                                <Badge className="bg-emerald-600 text-white hover:bg-emerald-700">
                                    Revenue Center
                                </Badge>
                            ) : (
                                <Badge
                                    variant="secondary"
                                    className="bg-primary/10 text-primary"
                                >
                                    Cost Center
                                </Badge>
                            )}
                        </div>

                        <h3 className="text-base font-semibold text-foreground">
                            {node.name}
                        </h3>

                        {node.directorate_group && (
                            <p className="text-sm text-muted-foreground">
                                Group: {node.directorate_group}
                            </p>
                        )}
                    </div>

                    <div className="text-right text-xs text-muted-foreground">
                        Depth {node.depth}
                    </div>
                </div>
            </div>

            {hasChildren && (
                <div className="ml-4 space-y-3">
                    {node.children.map((child) => (
                        <OrganizationTreeItem key={child.id} node={child} />
                    ))}
                </div>
            )}
        </div>
    );
}

function OrganizationsIndex({ organizations, summary }: Props) {
    return (
        <>
            <Head title="Struktur Organisasi APN" />

            <main className="min-h-full bg-background p-4 sm:p-6 lg:p-8">
                <div className="mx-auto w-full max-w-7xl space-y-6">
                    <section className="rounded-lg border bg-card p-6 shadow-sm">
                        <div className="flex flex-col gap-2">
                            <p className="text-sm font-semibold text-primary uppercase">
                                Sprint 2 - Master Data Organization
                            </p>
                            <h1 className="text-2xl font-semibold text-foreground">
                                Struktur Organisasi APN
                            </h1>
                            <p className="max-w-3xl text-muted-foreground">
                                Struktur organisasi ini menjadi master data
                                utama untuk membangun Dashboard Pohon EBITDA,
                                mapping revenue center, cost center, dan
                                agregasi EBITDA dari sub-unit ke level Direksi.
                            </p>
                        </div>
                    </section>

                    <section className="grid gap-4 md:grid-cols-4">
                        <StatCard
                            title="Total Node"
                            value={summary.total_nodes}
                            icon={Network}
                        />
                        <StatCard
                            title="Revenue Center"
                            value={summary.revenue_centers}
                            icon={CircleDot}
                        />
                        <StatCard
                            title="Cost Center"
                            value={summary.cost_centers}
                            icon={ShieldCheck}
                        />
                        <StatCard
                            title="Max Depth"
                            value={summary.max_depth}
                            icon={Building2}
                        />
                    </section>

                    <Card className="rounded-lg border bg-card shadow-sm">
                        <CardHeader className="border-b">
                            <CardTitle className="text-foreground">
                                Organization Tree
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="p-6">
                            <div className="space-y-4">
                                {organizations.map((node) => (
                                    <OrganizationTreeItem
                                        key={node.id}
                                        node={node}
                                    />
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </main>
        </>
    );
}

OrganizationsIndex.layout = {
    breadcrumbs: [
        {
            title: 'Organisasi',
            href: organizationsIndex(),
        },
    ],
};

export default OrganizationsIndex;
