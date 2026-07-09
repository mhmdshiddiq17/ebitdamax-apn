import { Head, router } from '@inertiajs/react';
import { Pencil, Save, Search, Users } from 'lucide-react';
import type { FormEvent } from 'react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { index as sdmDataIndex, update } from '@/routes/sdm-data';
import type { SdmDataPageProps, SdmEntry } from '@/types/monitoring';

function SdmRow({ entry }: { entry: SdmEntry }) {
    const [isEditing, setIsEditing] = useState(entry.jumlah_karyawan === 0);
    const [jumlahKaryawan, setJumlahKaryawan] = useState(
        String(entry.jumlah_karyawan),
    );
    const [saving, setSaving] = useState(false);

    const save = () => {
        setSaving(true);
        router.put(
            update.url(entry.id),
            { jumlah_karyawan: jumlahKaryawan },
            {
                preserveScroll: true,
                onSuccess: () => setIsEditing(false),
                onFinish: () => setSaving(false),
            },
        );
    };

    return (
        <TableRow>
            <TableCell>
                <p className="font-medium">{entry.nama_koperasi}</p>
                <p className="text-xs text-muted-foreground">
                    {[entry.nama_kodim, entry.kota_kabupaten]
                        .filter(Boolean)
                        .join(' · ')}
                </p>
            </TableCell>
            <TableCell className="w-40">
                {isEditing ? (
                    <Input
                        type="number"
                        min={0}
                        autoFocus
                        value={jumlahKaryawan}
                        onChange={(e) => setJumlahKaryawan(e.target.value)}
                        className="text-right"
                    />
                ) : (
                    <p className="text-right font-semibold tabular-nums">
                        {entry.jumlah_karyawan.toLocaleString('id-ID')}
                    </p>
                )}
            </TableCell>
            <TableCell className="w-32 text-right">
                {isEditing ? (
                    <Button size="sm" disabled={saving} onClick={save}>
                        <Save className="mr-1 h-4 w-4" />
                        Simpan
                    </Button>
                ) : (
                    <Button
                        size="sm"
                        variant="outline"
                        onClick={() => setIsEditing(true)}
                    >
                        <Pencil className="mr-1 h-4 w-4" />
                        Edit
                    </Button>
                )}
            </TableCell>
        </TableRow>
    );
}

export default function SdmDataIndex({
    entries,
    summary,
    filters,
}: SdmDataPageProps) {
    const [search, setSearch] = useState(filters.search);

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
                            Daftar KDKMP dari data pembangunan. Isi jumlah
                            karyawan yang sudah ditempatkan di tiap KDKMP.
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
                            <form
                                onSubmit={submitSearch}
                                className="flex max-w-sm items-center gap-2"
                            >
                                <div className="relative flex-1">
                                    <Search className="absolute top-1/2 left-2.5 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                                    <Input
                                        value={search}
                                        onChange={(e) =>
                                            setSearch(e.target.value)
                                        }
                                        placeholder="Cari nama koperasi, NIK, atau kodim..."
                                        className="pl-8"
                                    />
                                </div>
                                <Button type="submit" variant="outline">
                                    Cari
                                </Button>
                            </form>

                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>KDKMP</TableHead>
                                        <TableHead>Jumlah Karyawan</TableHead>
                                        <TableHead className="text-right">
                                            Aksi
                                        </TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {entries.length === 0 && (
                                        <TableRow>
                                            <TableCell
                                                colSpan={3}
                                                className="text-center text-muted-foreground"
                                            >
                                                Tidak ada data yang cocok.
                                            </TableCell>
                                        </TableRow>
                                    )}
                                    {entries.map((entry) => (
                                        <SdmRow key={entry.id} entry={entry} />
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </div>
            </div>
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
