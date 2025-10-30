<script setup lang="ts">
defineProps<{
    title: string;
}>();
import { AlertDialog, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import { PlusCircle } from 'lucide-vue-next';
import Button from './ui/button/Button.vue';
</script>

<template>
    <AlertDialog>
        <AlertDialogTrigger>
            <Button size="default" class="flex items-center gap-2">
                <PlusCircle class="h-4 w-4" />
                Nouveau
            </Button>
        </AlertDialogTrigger>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ title }}</AlertDialogTitle>
            </AlertDialogHeader>
            <slot />
        </AlertDialogContent>
    </AlertDialog>
</template>
