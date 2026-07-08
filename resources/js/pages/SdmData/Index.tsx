import { Head, router, useForm } from '@inertiajs/react';
import { Pencil, Plus, Search, Trash2, Users } from 'lucide-react';
import type { FormEvent } from 'react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    destroy,
    index as sdmDataIndex,
    store,
    update,
} from '@/routes/sdm-data';
import type { SdmDataPageProps, SdmEntry } from '@/types/monitoring';

type SdmFormData = {
    nama_koperasi: string;
    jumlah_karyawan: string;
    catatan: string;
};

function emptyForm(): SdmFormData {
    return { nama_koperasi: '', jumlah_karyawan: '0', catatan: '' };
}

export default function SdmDataIndex({
    entries,
    summary,
    filters,
}: SdmDataPageProps) {
    const [search, setSearch] = useState(filters.search);
    const [dialogOpen, setDialogOpen] = useState(false);
    const [editing, setEditing] = useState<SdmEntry | null>(null);

    const form = useForm<SdmFormData>(emptyForm());

    const openCreate = () => {
        setEditing(null);
        form.setData(emptyForm());
        setDialogOpen(true);
    };

    const openEdit = (entry: SdmEntry) => {
        setEditing(entry);
        form.setData({
            nama_koperasi: entry.nama_koperasi,
            jumlah_karyawan: String(entry.jumlah_karyawan),
            catatan: entry.catatan ?? '',
        });
        setDialogOpen(true);
    };

    const submit = (event: FormEvent) => {
        event.preventDefault();

        const onSuccess = () => setDialogOpen(false);

        if (editing) {
            form.put(update.url(editing.id), {
                onSuccess,
                preserveScroll: true,
            });
        } else {
            form.post(store.url(), { onSuccess, preserveScroll: true });
        }
    };

    const remove = (entry: SdmEntry) => {
        if (!confirm(`Hapus data SDM untuk ${entry.nama_koperasi}?`)) {
            return;
        }

        router.delete(destroy.url(entry.id), { preserveScroll: true });
    };

    const submitSearch = (event: FormEvent) => {
        event.preventDefault();
        router.get(sdmDataIndex.url(), { search }, { preserveState: true });
    };

    return (
        <>
            <Head title="Data SDM KDKMP" />

            <div className="min-h-screen bg-background">
                <div className="space-y-6 p-6">
                    <div className="rounded-lg border bg-card p-6 shadow-sm">
                        <p className="text-sm font-medium tracking-wide text-primary uppercase">
                            Input Tim HC
                        </p>
                        <h1 className="mt-1 text-2xl font-bold text-foreground">
                            Data SDM KDKMP
                        </h1>
                        <p className="mt-2 max-w-4xl text-muted-foreground">
                            Jumlah karyawan yang sudah ditambahkan dan
                            ditempatkan per KDKMP. Data ini diisi manual oleh
                            tim HC.
                        </p>
                    </div>

                    <div className="grid gap-4 md:grid-cols-2">
                        <Card>
                            <CardContent className="flex items-center justify-between p-5">
                                <div>
                                    <p className="text-sm text-muted-foreground">
                                        KDKMP Sudah Ditambahkan Karyawan
                                    </p>
                                    <p className="mt-1 text-2xl font-bold">
                                        {summary.jumlah_kdkmp_ditambahkan.toLocaleString(
                                            'id-ID',
                                        )}
                                    </p>
                                </div>
                                <div className="rounded-full bg-emerald-500/10 p-3 text-emerald-600">
                                    <Users className="h-5 w-5" />
                                </div>
                            </CardContent>
                        </Card>
                        <Card>
                            <CardContent className="flex items-center justify-between p-5">
                                <div>
                                    <p className="text-sm text-muted-foreground">
                                        Total Karyawan Ditempatkan
                                    </p>
                                    <p className="mt-1 text-2xl font-bold">
                                        {summary.total_karyawan.toLocaleString(
                                            'id-ID',
                                        )}
                                    </p>
                                </div>
                                <div className="rounded-full bg-primary/10 p-3 text-primary">
                                    <Users className="h-5 w-5" />
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <Card>
                        <CardContent className="space-y-4 p-5">
                            <div className="flex flex-wrap items-center gap-3">
                                <form
                                    onSubmit={submitSearch}
                                    className="flex flex-1 items-center gap-2"
                                >
                                    <div className="relative max-w-sm flex-1">
                                        <Search className="absolute top-1/2 left-2.5 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                                        <Input
                                            value={search}
                                            onChange={(e) =>
                                                setSearch(e.target.value)
                                            }
                                            placeholder="Cari nama koperasi..."
                                            className="pl-8"
                                        />
                                    </div>
                                    <Button type="submit" variant="outline">
                                        Cari
                                    </Button>
                                </form>
                                <Button onClick={openCreate}>
                                    <Plus className="mr-1 h-4 w-4" />
                                    Tambah Data
                                </Button>
                            </div>

                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Nama Koperasi</TableHead>
                                        <TableHead className="text-right">
                                            Jumlah Karyawan
                                        </TableHead>
                                        <TableHead>Catatan</TableHead>
                                        <TableHead className="w-24 text-right">
                                            Aksi
                                        </TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {entries.length === 0 && (
                                        <TableRow>
                                            <TableCell
                                                colSpan={4}
                                                className="text-center text-muted-foreground"
                                            >
                                                Belum ada data.
                                            </TableCell>
                                        </TableRow>
                                    )}
                                    {entries.map((entry) => (
                                        <TableRow key={entry.id}>
                                            <TableCell className="font-medium">
                                                {entry.nama_koperasi}
                                            </TableCell>
                                            <TableCell className="text-right">
                                                {entry.jumlah_karyawan.toLocaleString(
                                                    'id-ID',
                                                )}
                                            </TableCell>
                                            <TableCell className="text-muted-foreground">
                                                {entry.catatan ?? '-'}
                                            </TableCell>
                                            <TableCell className="text-right">
                                                <Button
                                                    size="icon"
                                                    variant="ghost"
                                                    onClick={() =>
                                                        openEdit(entry)
                                                    }
                                                >
                                                    <Pencil className="h-4 w-4" />
                                                </Button>
                                                <Button
                                                    size="icon"
                                                    variant="ghost"
                                                    onClick={() =>
                                                        remove(entry)
                                                    }
                                                >
                                                    <Trash2 className="h-4 w-4 text-destructive" />
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </div>
            </div>

            <Dialog open={dialogOpen} onOpenChange={setDialogOpen}>
                <DialogContent>
                    <form onSubmit={submit}>
                        <DialogHeader>
                            <DialogTitle>
                                {editing ? 'Edit Data SDM' : 'Tambah Data SDM'}
                            </DialogTitle>
                            <DialogDescription>
                                Isi jumlah karyawan yang sudah ditempatkan di
                                KDKMP ini.
                            </DialogDescription>
                        </DialogHeader>

                        <div className="space-y-4 py-4">
                            <div className="space-y-2">
                                <Label htmlFor="nama_koperasi">
                                    Nama Koperasi
                                </Label>
                                <Input
                                    id="nama_koperasi"
                                    value={form.data.nama_koperasi}
                                    onChange={(e) =>
                                        form.setData(
                                            'nama_koperasi',
                                            e.target.value,
                                        )
                                    }
                                    required
                                />
                                {form.errors.nama_koperasi && (
                                    <p className="text-sm text-destructive">
                                        {form.errors.nama_koperasi}
                                    </p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="jumlah_karyawan">
                                    Jumlah Karyawan
                                </Label>
                                <Input
                                    id="jumlah_karyawan"
                                    type="number"
                                    min={0}
                                    value={form.data.jumlah_karyawan}
                                    onChange={(e) =>
                                        form.setData(
                                            'jumlah_karyawan',
                                            e.target.value,
                                        )
                                    }
                                    required
                                />
                                {form.errors.jumlah_karyawan && (
                                    <p className="text-sm text-destructive">
                                        {form.errors.jumlah_karyawan}
                                    </p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="catatan">
                                    Catatan (opsional)
                                </Label>
                                <Input
                                    id="catatan"
                                    value={form.data.catatan}
                                    onChange={(e) =>
                                        form.setData('catatan', e.target.value)
                                    }
                                />
                            </div>
                        </div>

                        <DialogFooter>
                            <Button
                                type="button"
                                variant="outline"
                                onClick={() => setDialogOpen(false)}
                            >
                                Batal
                            </Button>
                            <Button type="submit" disabled={form.processing}>
                                Simpan
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </>
    );
}

SdmDataIndex.layout = {
    surface: 'financial-light',
    breadcrumbs: [
        {
            title: 'Data SDM',
            href: sdmDataIndex(),
        },
    ],
};
