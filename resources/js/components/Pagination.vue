<script setup lang="ts">
import type { PaginationLink } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, ArrowRight } from 'lucide-vue-next';

defineProps<{
    links: PaginationLink[];
}>();
</script>

<template>
    <nav class="mt-4 flex items-center justify-between" aria-label="Pagination">
        <div class="flex flex-1 justify-between sm:justify-start">
            <!-- Previous Page Link -->
            <template v-if="links[0].url">
                <Link
                    :href="links[0].url"
                    class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    preserve-scroll
                >
                    <ArrowLeft />Précédent
                </Link>
            </template>
            <span
                v-else
                class="relative inline-flex cursor-not-allowed items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-300"
            >
                <ArrowLeft /> Précédent
            </span>

            <!-- Page Numbers -->
            <div class="ml-2 hidden sm:flex">
                <template v-for="(link, index) in links.slice(1, -1)" :key="index">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="relative mx-1 inline-flex items-center rounded-md border px-4 py-2 text-sm font-medium"
                        :class="{
                            'z-10 border-blue-500 bg-blue-50 text-blue-600': link.active,
                            'border-gray-300 bg-white text-gray-500 hover:bg-gray-50': !link.active,
                        }"
                        preserve-scroll
                    >
                        <span v-html="link.label" />
                    </Link>
                    <span
                        v-else
                        class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700"
                    >
                        <span v-html="link.label" />
                    </span>
                </template>
            </div>

            <!-- Next Page Link -->
            <template v-if="links[links.length - 1].url">
                <Link
                    :href="links[links.length - 1].url"
                    class="relative ml-2 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    preserve-scroll
                >
                    <ArrowRight /> Suivant
                </Link>
            </template>
            <span
                v-else
                class="relative ml-2 inline-flex cursor-not-allowed items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-300"
            >
                <ArrowRight /> Suivant
            </span>
        </div>
    </nav>
</template>
