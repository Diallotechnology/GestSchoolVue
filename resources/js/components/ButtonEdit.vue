<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { RouteHref } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Pencil } from 'lucide-vue-next';

defineProps<{
    href: string | RouteHref;
}>();
</script>
<template>
    <Link :href="href">
        <Button size="icon"><Pencil class="h-4 w-4" /></Button>
    </Link>
</template>
