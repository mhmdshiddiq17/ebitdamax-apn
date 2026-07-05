import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout';
import type { BreadcrumbItem } from '@/types';

export default function AppLayout({
    breadcrumbs = [],
    surface = 'default',
    children,
}: {
    breadcrumbs?: BreadcrumbItem[];
    surface?: 'default' | 'financial-light';
    children: React.ReactNode;
}) {
    return (
        <AppLayoutTemplate breadcrumbs={breadcrumbs} surface={surface}>
            {children}
        </AppLayoutTemplate>
    );
}
