<script setup lang="ts">
import PersonnelController from '@/actions/App/Http/Controllers/PersonnelController';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'tuteur edit',
        href: '/personnel/edit',
    },
];

const props = defineProps<{
    personnel: {
        id: number;
        nom: string;
        prenom: string;
        contact: string;
    };
}>();

// Initialisation du formulaire
const form = useForm({
    nom: props.personnel.nom,
    prenom: props.personnel.prenom,
    contact: props.personnel.contact,
});

// 🔥 Mettre à jour `form` si les props changent (important pour l'édition)
watch(
    props,
    (newProps) => {
        form.nom = newProps.personnel.nom;
        form.prenom = newProps.personnel.prenom;
        form.contact = newProps.personnel.contact;
    },
    { immediate: true },
);

// Soumission du formulaire
const submit = () => {
    form.patch(PersonnelController.update({ id: props.personnel.id }).url, {
        preserveScroll: true,
        onSuccess: () => {
            router.reload();
        },
    });
};
</script>

<template>
    <Head title="title" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card class="mx-auto space-y-6 lg:w-2/3">
            <CardTitle>
                <div class="m-3 text-center">Formulaire de mise à jour</div>
            </CardTitle>
            <CardContent class="justify-center p-4">
                <form @submit.prevent="submit">
                    <div class="grid gap-2">
                        <Label for="nom">Nom</Label>
                        <Input
                            id="nom"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nom"
                            required
                            placeholder="nom de la personne"
                        />
                        <InputError class="mt-2" :message="form.errors.nom" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="prenom">Prenom</Label>
                        <Input
                            id="prenom"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.prenom"
                            required
                            placeholder="prenom de la personne"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.prenom"
                        />
                    </div>
                    <div class="grid gap-2">
                        <Label for="contact">Contact</Label>
                        <Input
                            id="contact"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.contact"
                            required
                            placeholder="contact de la personne"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.contact"
                        />
                    </div>

                    <div class="mt-4 flex justify-center">
                        <Link
                            :href="PersonnelController.index().url"
                            class="hover:underline"
                        >
                            <Button
                                variant="destructive"
                                :disabled="form.processing"
                                >Annuler</Button
                            >
                        </Link>
                        <Button
                            type="submit"
                            class="mx-3"
                            :disabled="form.processing"
                            :class="{ 'opacity-50': form.processing }"
                        >
                            {{ form.processing ? 'Validation...' : 'Valider' }}
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
