<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import Button from '@/components/ui/button/Button.vue';
import { Form, useForm } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';

const props = defineProps<{ href: string }>();

const form = useForm({});

const deleteItem = () => {
    form.delete(props.href);
};
</script>

<template>
    <AlertDialog>
        <AlertDialogTrigger>
            <Button size="icon" variant="destructive" class="ml-1">
                <Trash2 class="h-4 w-4" />
            </Button>
        </AlertDialogTrigger>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Êtes-vous sûr de vouloir supprimer cet élément ?</AlertDialogTitle>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel :disabled="form.processing">Annuler</AlertDialogCancel>
                <Form @submit.prevent="deleteItem">
                    <AlertDialogAction type="submit" class="bg-red-600" :disabled="form.processing" :class="{ 'opacity-50': form.processing }">
                        {{ form.processing ? 'Suppression...' : 'Supprimer' }}
                    </AlertDialogAction>
                </Form>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
