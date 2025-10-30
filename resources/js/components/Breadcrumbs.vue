<script setup lang="ts">
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb';
import { Link } from '@inertiajs/vue3';

interface BreadcrumbItemType {
    title: string;
    href?: string;
}

defineProps<{
    breadcrumbs: BreadcrumbItemType[];
}>();
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in breadcrumbs" :key="index">
                <BreadcrumbItem>
                    <template v-if="index === breadcrumbs.length - 1">
                        <BreadcrumbPage>{{ item.title }}</BreadcrumbPage>
                    </template>
                    <template v-else>
                        <BreadcrumbLink as-child>
                            <Link :href="item.href ?? '#'">{{
                                item.title
                            }}</Link>
                        </BreadcrumbLink>
                    </template>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>

<!-- <script setup lang="ts">
import type { BreadcrumbItemType } from '@/types';
import { ChevronRight } from 'lucide-vue-next';

defineProps<{ items: BreadcrumbItemType[] }>();
</script>

<template>
    <nav class="mb-4 flex items-center text-sm text-muted-foreground">
        <template v-for="(item, index) in items" :key="index">
            <a
                v-if="item.href"
                :href="item.href"
                class="transition-colors hover:text-foreground"
            >
                {{ item.title }}
            </a>
            <span v-else>{{ item.title }}</span>

            <ChevronRight
                v-if="index < items.length - 1"
                class="mx-2 h-4 w-4 opacity-60"
            />
        </template>
    </nav>
</template> -->
