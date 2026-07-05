import { AppContent } from '@/components/app-content';
import { AppHeader } from '@/components/app-header';
import { AppShell } from '@/components/app-shell';
import { cn } from '@/lib/utils';
import type { AppLayoutProps } from '@/types';

export default function AppHeaderLayout({
    children,
    breadcrumbs,
    surface = 'default',
}: AppLayoutProps) {
    return (
        <AppShell
            variant="header"
            className={cn(
                surface === 'financial-light' &&
                    'financial-light bg-background text-foreground',
            )}
        >
            <AppHeader breadcrumbs={breadcrumbs} />
            <AppContent variant="header">{children}</AppContent>
        </AppShell>
    );
}
