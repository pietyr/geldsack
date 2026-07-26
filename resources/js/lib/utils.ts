import type { InertiaLinkProps } from '@inertiajs/vue3';
import type { ClassValue } from 'clsx';
import { clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}

export function formatDate(dateString: string): string {
    if (!dateString) {
        return '';
    }

    return new Intl.DateTimeFormat('pl-PL', {
        day: 'numeric',
        month: '2-digit',
        year: 'numeric',
    }).format(new Date(dateString));
}
