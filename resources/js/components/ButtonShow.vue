<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { RouteHref } from '@/types';
import { Link } from '@inertiajs/vue3';
import { EyeIcon } from 'lucide-vue-next';

interface Props {
    href: string | RouteHref;
}

defineProps<Props>();
</script>

<template>
    <Link :href="href">
        <Button size="icon" class="mr-2"> <EyeIcon class="h-4 w-4" /> </Button>
    </Link>
</template>
