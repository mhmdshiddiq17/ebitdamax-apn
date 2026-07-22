import { Head, router, useForm } from '@inertiajs/react';
import { FolderKanban, Pencil, Plus, Search, Trash2 } from 'lucide-react';
import type { FormEvent } from 'react';
import { useState } from 'react';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
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
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    destroy as destroyTaskCategory,
    index as taskCategoriesIndex,
    store as storeTaskCategory,
    update as updateTaskCategory,
} from '@/routes/task-categories';
import type {
    TaskCategoryFilters,
    TaskCategoryItem,
    TaskCategoryPaginatedResponse,
} from '@/types/task-category';

type Props = {
    taskCategories: TaskCategoryPaginatedResponse;
    filters: TaskCategoryFilters;
};

type TaskCategoryFormData = {
    name: string;
    description: string;
};

const defaultForm: TaskCategoryFormData = {
    name: '',
    description: '',
};

function FieldError({ message }: { message?: string }) {
    if (!message) {
        return null;
    }

    return <p className="text-xs text-destructive">{message}</p>;
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

export default function TaskCategoriesIndex({
    taskCategories,
    filters,
}: Props) {
    const [selectedCategory, setSelectedCategory] =
        useState<TaskCategoryItem | null>(null);
    const [deleteTarget, setDeleteTarget] = useState<TaskCategoryItem | null>(
        null,
    );
    const [isFormOpen, setIsFormOpen] = useState(false);
    const [filterForm, setFilterForm] = useState({
        search: filters.search ?? '',
        sort: filters.sort ?? 'name',
        direction: filters.direction ?? 'asc',
    });

    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm<TaskCategoryFormData>(defaultForm);

    const submitFilters = (event: FormEvent) => {
        event.preventDefault();

        router.get(taskCategoriesIndex.url(), filterForm, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const openCreateForm = () => {
        setSelectedCategory(null);
        clearErrors();
        reset();
        setData(defaultForm);
        setIsFormOpen(true);
    };

    const openEditForm = (category: TaskCategoryItem) => {
        setSelectedCategory(category);
        clearErrors();
        setData({
            name: category.name,
            description: category.description ?? '',
        });
        setIsFormOpen(true);
    };

    const closeForm = () => {
        setIsFormOpen(false);
        setSelectedCategory(null);
        reset();
        clearErrors();
    };

    const submit = (event: FormEvent) => {
        event.preventDefault();

        const options = {
            preserveScroll: true,
            onSuccess: closeForm,
        };

        if (selectedCategory) {
            put(updateTaskCategory.url(selectedCategory.slug), options);

            return;
        }

        post(storeTaskCategory.url(), options);
    };

    const confirmDelete = () => {
        if (!deleteTarget) {
            return;
        }

        router.delete(destroyTaskCategory.url(deleteTarget.slug), {
            preserveScroll: true,
            onSuccess: () => setDeleteTarget(null),
        });
    };

    return (
        <>
            <Head title="Task Categories" />

            <main className="min-h-screen bg-background p-4 sm:p-6 lg:p-8">
                <div className="mx-auto w-full max-w-7xl space-y-6">
                    <section className="flex flex-col gap-4 rounded-lg border bg-card p-6 shadow-sm lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p className="text-sm font-semibold text-primary uppercase">
                                Master Task
                            </p>
                            <h1 className="mt-1 text-2xl font-semibold text-foreground">
                                Task Categories
                            </h1>
                            <p className="mt-2 max-w-3xl text-muted-foreground">
                                Kelola kategori untuk mengelompokkan master task
                                operasional.
                            </p>
                        </div>

                        <Button type="button" onClick={openCreateForm}>
                            <Plus className="size-4" />
                            Tambah Kategori
                        </Button>
                    </section>

                    <Card className="rounded-lg border bg-card shadow-sm">
                        <CardContent className="p-5">
                            <form
                                onSubmit={submitFilters}
                                className="grid gap-4 lg:grid-cols-[1fr_180px_160px_auto]"
                            >
                                <div className="space-y-2">
                                    <Label>Search</Label>
                                    <div className="relative">
                                        <Search className="absolute top-3 left-3 size-4 text-muted-foreground" />
                                        <Input
                                            value={filterForm.search}
                                            onChange={(event) =>
                                                setFilterForm((current) => ({
                                                    ...current,
                                                    search: event.target.value,
                                                }))
                                            }
                                            placeholder="Cari nama, slug, atau deskripsi"
                                            className="pl-9"
                                        />
                                    </div>
                                </div>

                                <div className="space-y-2">
                                    <Label>Sorting</Label>
                                    <Select
                                        value={filterForm.sort}
                                        onValueChange={(value) =>
                                            setFilterForm((current) => ({
                                                ...current,
                                                sort: value,
                                            }))
                                        }
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Sorting" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="name">
                                                Nama
                                            </SelectItem>
                                            <SelectItem value="created_at">
                                                Dibuat
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div className="space-y-2">
                                    <Label>Arah</Label>
                                    <Select
                                        value={filterForm.direction}
                                        onValueChange={(value) =>
                                            setFilterForm((current) => ({
                                                ...current,
                                                direction:
                                                    value === 'desc'
                                                        ? 'desc'
                                                        : 'asc',
                                            }))
                                        }
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Arah" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="asc">
                                                Ascending
                                            </SelectItem>
                                            <SelectItem value="desc">
                                                Descending
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div className="flex items-end">
                                    <Button type="submit" className="w-full">
                                        Filter
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg border bg-card shadow-sm">
                        <CardHeader className="border-b">
                            <div className="flex items-center justify-between gap-4">
                                <CardTitle>Data Task Category</CardTitle>
                                <Badge variant="outline">
                                    {taskCategories.total} kategori
                                </Badge>
                            </div>
                        </CardHeader>
                        <CardContent className="p-0">
                            <Table>
                                <TableHeader>
                                    <TableRow className="bg-muted/40">
                                        <TableHead className="min-w-[280px] p-4">
                                            Kategori
                                        </TableHead>
                                        <TableHead className="p-4">
                                            Deskripsi
                                        </TableHead>
                                        <TableHead className="p-4 text-right">
                                            Task
                                        </TableHead>
                                        <TableHead className="w-[180px] p-4 text-right">
                                            Aksi
                                        </TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {taskCategories.data.length === 0 && (
                                        <TableRow>
                                            <TableCell
                                                colSpan={4}
                                                className="p-8 text-center text-muted-foreground"
                                            >
                                                Data kategori task belum
                                                tersedia.
                                            </TableCell>
                                        </TableRow>
                                    )}

                                    {taskCategories.data.map((category) => (
                                        <TableRow key={category.uuid}>
                                            <TableCell className="p-4">
                                                <div className="flex items-center gap-3">
                                                    <div className="flex size-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                                        <FolderKanban className="size-5" />
                                                    </div>
                                                    <div>
                                                        <p className="font-medium text-foreground">
                                                            {category.name}
                                                        </p>
                                                        <p className="text-xs text-muted-foreground">
                                                            {category.slug}
                                                        </p>
                                                    </div>
                                                </div>
                                            </TableCell>
                                            <TableCell className="max-w-xl p-4 text-muted-foreground">
                                                {category.description ?? '-'}
                                            </TableCell>
                                            <TableCell className="p-4 text-right">
                                                {category.tasks_count}
                                            </TableCell>
                                            <TableCell className="p-4">
                                                <div className="flex justify-end gap-2">
                                                    <Button
                                                        type="button"
                                                        variant="outline"
                                                        size="sm"
                                                        onClick={() =>
                                                            openEditForm(
                                                                category,
                                                            )
                                                        }
                                                    >
                                                        <Pencil className="size-4" />
                                                        Edit
                                                    </Button>
                                                    <Button
                                                        type="button"
                                                        variant="destructive"
                                                        size="sm"
                                                        onClick={() =>
                                                            setDeleteTarget(
                                                                category,
                                                            )
                                                        }
                                                    >
                                                        <Trash2 className="size-4" />
                                                        Hapus
                                                    </Button>
                                                </div>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>

                    {taskCategories.last_page > 1 && (
                        <div className="flex flex-wrap items-center justify-between gap-4">
                            <p className="text-sm text-muted-foreground">
                                Menampilkan {taskCategories.from ?? 0}-
                                {taskCategories.to ?? 0} dari{' '}
                                {taskCategories.total} kategori
                            </p>
                            <div className="flex flex-wrap gap-2">
                                {taskCategories.links.map((link) => (
                                    <Button
                                        key={`${link.label}-${link.url}`}
                                        type="button"
                                        variant={
                                            link.active ? 'default' : 'outline'
                                        }
                                        size="sm"
                                        disabled={!link.url}
                                        onClick={() => {
                                            if (link.url) {
                                                router.visit(link.url, {
                                                    preserveScroll: true,
                                                    preserveState: true,
                                                });
                                            }
                                        }}
                                    >
                                        {paginationLabel(link.label)}
                                    </Button>
                                ))}
                            </div>
                        </div>
                    )}
                </div>
            </main>

            <Dialog open={isFormOpen} onOpenChange={setIsFormOpen}>
                <DialogContent className="sm:max-w-lg">
                    <form onSubmit={submit} className="space-y-5">
                        <DialogHeader>
                            <DialogTitle>
                                {selectedCategory
                                    ? 'Edit Task Category'
                                    : 'Tambah Task Category'}
                            </DialogTitle>
                            <DialogDescription>
                                Slug kategori dibuat otomatis dari nama.
                            </DialogDescription>
                        </DialogHeader>

                        <div className="space-y-2">
                            <Label>Nama Kategori</Label>
                            <Input
                                value={data.name}
                                onChange={(event) =>
                                    setData('name', event.target.value)
                                }
                                placeholder="Contoh: Operasional Harian"
                            />
                            <FieldError message={errors.name} />
                        </div>

                        <div className="space-y-2">
                            <Label>Deskripsi</Label>
                            <textarea
                                value={data.description}
                                onChange={(event) =>
                                    setData('description', event.target.value)
                                }
                                className="min-h-28 w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                                placeholder="Deskripsi kategori task"
                            />
                            <FieldError message={errors.description} />
                        </div>

                        <DialogFooter>
                            <Button
                                type="button"
                                variant="outline"
                                onClick={closeForm}
                            >
                                Batal
                            </Button>
                            <Button type="submit" disabled={processing}>
                                {processing ? 'Menyimpan...' : 'Simpan'}
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>

            <Dialog
                open={deleteTarget !== null}
                onOpenChange={(open) => !open && setDeleteTarget(null)}
            >
                <DialogContent className="sm:max-w-md">
                    <DialogHeader>
                        <DialogTitle>Hapus Task Category</DialogTitle>
                        <DialogDescription>
                            Kategori {deleteTarget?.name} akan dihapus permanen.
                            Tindakan ini tidak dapat dibatalkan.
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => setDeleteTarget(null)}
                        >
                            Batal
                        </Button>
                        <Button
                            type="button"
                            variant="destructive"
                            onClick={confirmDelete}
                        >
                            Hapus
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </>
    );
}
