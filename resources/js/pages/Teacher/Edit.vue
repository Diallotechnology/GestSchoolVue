<script setup lang="ts">
import TeacherController from '@/actions/App/Http/Controllers/TeacherController';
import InputError from '@/components/InputError.vue';
import SelectTag from '@/components/SelectTag.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Classe, Matiere } from '@/types/models';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'professeur edit',
        href: '/teacher',
    },
];

const props = defineProps<{
    teacher: {
        id: number;
        nom: string;
        prenom: string;
        contact: string;
        classes: { id: number; nom: string }[];
        matieres: { id: number; nom: string }[];
    };
    matieres: Matiere[];
    classes: Classe[];
}>();

// Initialisation du formulaire
const form = useForm({
    nom: props.teacher.nom,
    prenom: props.teacher.prenom,
    contact: props.teacher.contact,
    classe_id: props.teacher.classes.map((c) => c.id),
    matiere_id: props.teacher.matieres.map((m) => m.id),
});

// 🔥 Mettre à jour `form` si les props changent (important pour l'édition)
watch(
    props,
    (newProps) => {
        form.nom = newProps.teacher.nom;
        form.prenom = newProps.teacher.prenom;
        form.contact = newProps.teacher.contact;
        form.classe_id = newProps.teacher.classes.map((c) => c.id);
        form.matiere_id = newProps.teacher.matieres.map((m) => m.id);
    },
    { immediate: true },
);

// Soumission du formulaire
const submit = () => {
    form.patch(TeacherController.update({ id: props.teacher.id }).url, {
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
                        <Label for="prenom">Prenom</Label>
                        <Input
                            id="prenom"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.prenom"
                            required
                            placeholder="prenom du professeur"
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
                            placeholder="contact du professeur"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.contact"
                        />
                    </div>

                    <div class="grid gap-2">
                        <Label for="filiere">les classes enseignes</Label>
                        <SelectTag
                            v-model="form.classe_id"
                            :options="classes"
                            placeholder="Choisir les classes"
                            label="full_classe_name"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.classe_id"
                        />
                    </div>

                    <div class="grid gap-2">
                        <Label for="filiere">les matieres enseignes</Label>
                        <SelectTag
                            v-model="form.matiere_id"
                            :options="matieres"
                            placeholder="Choisir les matieres"
                            label="nom"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.matiere_id"
                        />
                    </div>
                    <div class="mt-4 flex justify-center">
                        <Link
                            :href="TeacherController.index().url"
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
