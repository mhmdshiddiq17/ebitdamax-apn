import { Head, Link } from '@inertiajs/react';
import { CheckCircle2, ClipboardList, Clock } from 'lucide-react';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import type { PaginatedResponse } from '@/types/ebitda';
import type { TaskCategoryOption } from '@/types/task';
import type { UserRole } from '@/types/user';

type CompletedTaskReport = {
    id: number;
    uuid: string;
    started_at: string | null;
    finished_at: string | null;
    duration_minutes: number | null;
    status_label: string;
    task: {
        id: number;
        uuid: string;
        name: string;
        description: string | null;
        time_require: number;
        task_category: TaskCategoryOption;
        role: UserRole;
    };
};

type Props = {
    reports: PaginatedResponse<CompletedTaskReport>;
};

function formatDateTime(value: string | null) {
    if (!value) {
        return '-';
    }

    return new Intl.DateTimeFormat('id-ID', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(value));
}

function paginationLabel(label: string) {
    if (label.includes('Previous')) {
        return 'Sebelumnya';
    }

    if (label.includes('Next')) {
        return 'Berikutnya';
    }

    return label;
}

export default function CompletedTaskDashboard({ reports }: Props) {
    return (
        <>
            <Head title="Tugas sudah selesai" />

            <main className="min-h-screen bg-background p-4 sm:p-6 lg:p-8">
                <div className="mx-auto w-full max-w-7xl space-y-6">
                    <section className="flex flex-col gap-4 rounded-lg border bg-card p-6 shadow-sm lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p className="text-sm font-semibold text-primary uppercase">
                                Laporan Pekerjaan
                            </p>
                            <h1 className="mt-1 text-2xl font-semibold text-foreground">
                                Tugas sudah selesai
                            </h1>
                            <p className="mt-2 max-w-3xl text-muted-foreground">
                                Riwayat tugas yang sudah diselesaikan oleh user
                                yang sedang login.
                            </p>
                        </div>
                    </section>

                    <Card className="rounded-lg border bg-card shadow-sm">
                        <CardHeader className="border-b">
                            <CardTitle>Riwayat Tugas Selesai</CardTitle>
                        </CardHeader>
                        <CardContent className="p-0">
                            <Table>
                                <TableHeader>
                                    <TableRow className="bg-muted/40">
                                        <TableHead className="min-w-[260px] p-4">
                                            Nama Task
                                        </TableHead>
                                        <TableHead className="p-4">
                                            Kategori
                                        </TableHead>
                                        <TableHead className="p-4">
                                            PIC Role
                                        </TableHead>
                                        <TableHead className="p-4">
                                            Mulai
                                        </TableHead>
                                        <TableHead className="p-4">
                                            Selesai
                                        </TableHead>
                                        <TableHead className="p-4 text-right">
                                            Durasi
                                        </TableHead>
                                        <TableHead className="p-4">
                                            Status
                                        </TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {reports.data.length === 0 && (
                                        <TableRow>
                                            <TableCell
                                                colSpan={7}
                                                className="p-8 text-center text-muted-foreground"
                                            >
                                                Belum ada tugas selesai.
                                            </TableCell>
                                        </TableRow>
                                    )}

                                    {reports.data.map((report) => (
                                        <TableRow key={report.uuid}>
                                            <TableCell className="p-4">
                                                <div className="flex items-center gap-3">
                                                    <div className="flex size-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                                        <ClipboardList className="size-5" />
                                                    </div>
                                                    <div>
                                                        <p className="font-medium text-foreground">
                                                            {report.task.name}
                                                        </p>
                                                        <p className="text-xs text-muted-foreground">
                                                            {report.task
                                                                .description ??
                                                                '-'}
                                                        </p>
                                                    </div>
                                                </div>
                                            </TableCell>
                                            <TableCell className="p-4">
                                                {report.task.task_category.name}
                                            </TableCell>
                                            <TableCell className="p-4">
                                                <Badge>
                                                    {report.task.role.name}
                                                </Badge>
                                            </TableCell>
                                            <TableCell className="p-4">
                                                {formatDateTime(
                                                    report.started_at,
                                                )}
                                            </TableCell>
                                            <TableCell className="p-4">
                                                {formatDateTime(
                                                    report.finished_at,
                                                )}
                                            </TableCell>
                                            <TableCell className="p-4 text-right">
                                                <span className="inline-flex items-center gap-1">
                                                    <Clock className="size-4 text-muted-foreground" />
                                                    {report.duration_minutes ??
                                                        0}{' '}
                                                    menit
                                                </span>
                                            </TableCell>
                                            <TableCell className="p-4">
                                                <Badge>
                                                    <CheckCircle2 className="size-3" />
                                                    {report.status_label}
                                                </Badge>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>

                    {reports.last_page > 1 && (
                        <div className="flex flex-wrap items-center justify-between gap-4">
                            <p className="text-sm text-muted-foreground">
                                Menampilkan {reports.from ?? 0}-
                                {reports.to ?? 0} dari {reports.total} laporan
                            </p>
                            <div className="flex flex-wrap gap-2">
                                {reports.links.map((link) => (
                                    <Button
                                        key={`${link.label}-${link.url}`}
                                        asChild={Boolean(link.url)}
                                        type="button"
                                        variant={
                                            link.active ? 'default' : 'outline'
                                        }
                                        size="sm"
                                        disabled={!link.url}
                                    >
                                        {link.url ? (
                                            <Link
                                                href={link.url}
                                                preserveScroll
                                            >
                                                {paginationLabel(link.label)}
                                            </Link>
                                        ) : (
                                            <span>
                                                {paginationLabel(link.label)}
                                            </span>
                                        )}
                                    </Button>
                                ))}
                            </div>
                        </div>
                    )}
                </div>
            </main>
        </>
    );
}
