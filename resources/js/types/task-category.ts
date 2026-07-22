import type { PaginatedResponse } from '@/types/ebitda';

export type TaskCategoryItem = {
    id: number;
    uuid: string;
    name: string;
    slug: string;
    description: string | null;
    tasks_count: number;
    created_at: string | null;
    updated_at: string | null;
};

export type TaskCategoryFilters = {
    search: string;
    sort: string;
    direction: 'asc' | 'desc';
};

export type TaskCategoryPaginatedResponse = PaginatedResponse<TaskCategoryItem>;
