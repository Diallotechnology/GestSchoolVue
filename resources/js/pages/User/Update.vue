<script setup lang="ts">
import UserController from '@/actions/App/Http/Controllers/UserController';
import InputError from '@/components/InputError.vue';
import Select2 from '@/components/Select2.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { genres } from '@/types/genre';
import { RoleOption } from '@/types/models';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User edit',
        href: '/user',
    },
];

const props = defineProps<{
    user: {
        id: number;
        name: string;
        email: string;
        role: string;
        sexe: string;
        userable_id: number;
    };
    roles: RoleOption[];
    parents: {
        id: number;
        nom: string;
        prenom: string;
        contact?: string;
        reference?: string;
    }[];
}>();

const userable = ref([]);

// Initialisation du formulaire
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
    sexe: props.user.sexe,
    userable_id: props.user.userable_id,
});

// 🔥 Mettre à jour `form` si les props changent (important pour l'édition)
watch(
    props,
    (newProps) => {
        form.name = newProps.user.name;
        form.email = newProps.user.email;
        form.role = newProps.user.role;
        form.sexe = newProps.user.sexe;
        form.userable_id = newProps.user.userable_id;
    },
    { immediate: true },
);

// 🔥 Charger dynamiquement les utilisateurs selon le rôle choisi
watch(
    () => form.role,
    async (newRole) => {
        if (!newRole) return;

        const { url, method } = UserController.fetch_Role({
            query: { role: newRole },
        });

        const response = await fetch(url, {
            method,
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        if (!response.ok) {
            console.error('Erreur serveur:', response.status);
            return;
        }

        userable.value = await response.json();
    },
    { immediate: true }, // 👈 Ajout crucial
);

// Soumission du formulaire
const submit = () => {
    form.patch(UserController.update({ id: props.user.id }).url, {
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
                <form @submit.prevent="submit" class="">
                    <div class="grid gap-2">
                        <Label for="name">Email</Label>
                        <Input
                            id="name"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            placeholder="email de l'utilisateur"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="grid gap-2">
                        <Select2
                            label="nom"
                            placeholder="choisir genre"
                            v-model="form.sexe"
                            :options="[
                                { id: '', name: 'choisire un genre' },
                                ...genres,
                            ]"
                            >Genre</Select2
                        >

                        <InputError class="mt-2" :message="form.errors.role" />
                    </div>
                    <div class="grid gap-2">
                        <Select2
                            label="nom"
                            placeholder="choisir role"
                            v-model="form.role"
                            :options="[
                                { id: '', name: 'Trier par role' },
                                ...roles,
                            ]"
                            >Role</Select2
                        >

                        <InputError class="mt-2" :message="form.errors.role" />
                    </div>

                    <div class="grid gap-2">
                        <Select2
                            label="full_name"
                            :placeholder="`Sélectionner un ${form.role || 'utilisateur'}`"
                            v-model="form.userable_id"
                            :options="[
                                { id: '', name: 'Sélectionner' },
                                ...(userable ?? []),
                            ]"
                        >
                            Liste des {{ form.role || 'utilisateurs' }}
                        </Select2>

                        <InputError class="mt-2" :message="form.errors.role" />
                    </div>
                    <div class="mt-4 flex justify-center">
                        <Link
                            :href="UserController.index().url"
                            class="text-blue-500 hover:underline"
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
