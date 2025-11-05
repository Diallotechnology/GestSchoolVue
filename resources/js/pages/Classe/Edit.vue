<script setup lang="ts">
import ClasseController from '@/actions/App/Http/Controllers/ClasseController';
import InputError from '@/components/InputError.vue';
import Select2 from '@/components/Select2.vue';
import SelectTag from '@/components/SelectTag.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Filiere, Matiere } from '@/types/models';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'classe edit',
        href: '/classe',
    },
];

const props = defineProps<{
    classe: {
        id: number;
        nom: string;
        scolarite: number;
        frais: number;
        filiere_id: number;
        matieres: { id: number; nom: string }[];
    };
    filieres: Filiere[];
    matieres: Matiere[];
}>();

// Initialisation du formulaire
const form = useForm({
    nom: props.classe.nom,
    scolarite: props.classe.scolarite,
    frais: props.classe.frais,
    filiere_id: props.classe.filiere_id,
    matiere_id: props.classe.matieres.map((m) => m.id),
});

// 🔥 Mettre à jour `form` si les props changent (important pour l'édition)
watch(
    props,
    (newProps) => {
        form.nom = newProps.classe.nom;
        form.scolarite = newProps.classe.scolarite;
        form.frais = newProps.classe.frais;
        form.filiere_id = newProps.classe.filiere_id;
        form.matiere_id = newProps.classe.matieres.map((m) => m.id);
    },
    { immediate: true },
);

// Soumission du formulaire
const submit = () => {
    form.patch(ClasseController.update({ id: props.classe.id }).url, {
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
                            placeholder="nom de la classe"
                        />
                        <InputError class="mt-2" :message="form.errors.nom" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="filiere">Filière</Label>
                        <Select2
                            :options="filieres"
                            label="nom"
                            v-model="form.filiere_id"
                            placeholder="Choisir une filière"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.filiere_id"
                        />
                    </div>

                    <div class="grid gap-2">
                        <Label for="filiere">les matieres enseignes</Label>
                        <SelectTag
                            v-model="form.matiere_id"
                            :options="matieres"
                            label="nom"
                            placeholder="Choisir les matieres"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.matiere_id"
                        />
                    </div>

                    <div class="grid gap-2">
                        <Label for="scolarite">Scolarité</Label>
                        <Input
                            id="scolarite"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.scolarite"
                            required
                            placeholder="nom de la classe"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.scolarite"
                        />
                    </div>

                    <div class="grid gap-2">
                        <Label for="frais">Frais</Label>
                        <Input
                            id="frais"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.frais"
                            required
                            placeholder="nom de la classe"
                        />
                        <InputError class="mt-2" :message="form.errors.frais" />
                    </div>
                    <div class="mt-4 flex justify-center">
                        <Link
                            :href="ClasseController.index().url"
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
