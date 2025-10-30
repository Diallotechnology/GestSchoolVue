import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface BreadcrumbItemType {
  title: string
  href?: string | null
}


export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export const formatMontant = (n: number): string =>
    n
        .toLocaleString()
        .replace(/[\u00A0\u202F]/g, ' ')
        .replace(/CFA\s*CFA/, 'CFA');

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    role: UserRole;
}

type RouteHref = {
    url: string;
    method: 'get' | 'post' | 'put' | 'patch' | 'delete';
};

export type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

// Type pour les liens de navigation principaux
export type PaginationNavigationLinks = {
    first: string | null;
    last: string | null;
    next: string | null;
    prev: string | null;
};

// Type pour les métadonnées de pagination
export type PaginationMeta = {
    current_page: number;
    from: number;
    last_page: number;
    links: PaginationLink[];
    path: string;
    per_page: number;
    to: number;
    total: number;
};


export interface PaginatedData<T> {
  data: T[]
  meta: PaginationMeta
  links: PaginationNavigationLinks
}


export type BreadcrumbItemType = BreadcrumbItem;
