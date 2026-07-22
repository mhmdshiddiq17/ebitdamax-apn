import type { PaginatedResponse } from '@/types/ebitda';
import type { RoleItem } from '@/types/role';

export type UserRole = Pick<
    RoleItem,
    'id' | 'name' | 'slug' | 'level' | 'level_label'
>;

export type UserItem = {
    id: number;
    role_id: number | null;
    name: string;
    username: string | null;
    email: string;
    email_verified_at: string | null;
    created_at: string | null;
    updated_at: string | null;
    role: UserRole | null;
};

export type UserFilters = {
    search: string;
    role_id: number | null;
    sort: string;
    direction: 'asc' | 'desc';
};

export type UserPaginatedResponse = PaginatedResponse<UserItem>;
