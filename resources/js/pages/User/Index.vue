<script setup lang="ts">
import UserController from '@/actions/App/Http/Controllers/UserController';
import ButtonDelete from '@/components/ButtonDelete.vue';
import ButtonEdit from '@/components/ButtonEdit.vue';
import InputError from '@/components/InputError.vue';
import Modal from '@/components/Modal.vue';
import { default as Select2 } from '@/components/Select2.vue';
import AlertDialogAction from '@/components/ui/alert-dialog/AlertDialogAction.vue';
import AlertDialogCancel from '@/components/ui/alert-dialog/AlertDialogCancel.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { useDynamicFilters } from '@/composables/useDynamicFilters';
import { useVModelRef } from '@/composables/useVModelRef';
import AppLayout from '@/layouts/AppLayout.vue';
import { PaginatedData, type BreadcrumbItem } from '@/types';
import { genres } from '@/types/genre';
import { RoleOption } from '@/types/models';
import { Head, useForm } from '@inertiajs/vue3';
import { SearchIcon, X } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'liste des utilisateurs',
        href: '/user',
    },
];

interface Row {
    id: number;
    email: string;
    role: string;
    sexe: string;
    etat: boolean;
    photo: string;
    change_password: string;
    created_at: string;
}

const props = defineProps<{
    rows: PaginatedData<Row>;
    roles: RoleOption[];
}>();
const form = useForm({
    email: '',
    role: '',
    sexe: '',
    userable_id: '',
});

const userable = ref([]);

// 🔥 Charger dynamiquement les utilisateurs selon le rôle choisi
watch(
    () => form.role,
    async (newRole) => {
        const { url, method } = UserController.fetch_Role({
            query: { role: newRole }, // 👈 obligatoire
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
);

const submit = () => {
    form.post(UserController.store().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
const { filters, reset } = useDynamicFilters(
    {
        search: '',
        role: '',
    },
    {
        controller: UserController, // ✅ Wayfinder
        debounceKeys: ['search'],
        delay: 300,
        persist: true,
    },
);

const role = useVModelRef(filters.role);
const searchQuery = useVModelRef(filters.search);

const filteredRows = computed(() => props.rows.data);
</script>
<template>
    <Head title="title" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex items-center justify-between p-4">
            <!-- Champ de recherche -->
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative w-64">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Recherche..."
                        class="w-full rounded border p-2 pl-10"
                        aria-label="Search"
                    />
                    <span
                        class="absolute inset-y-0 left-0 flex items-center px-2"
                    >
                        <SearchIcon class="size-6 text-muted-foreground" />
                    </span>
                </div>

                <div class="w-64">
                    <Select2
                        label="nom"
                        v-model="role"
                        placeholder="trier par role"
                        :options="[
                            { id: '', name: 'Trier par role' },
                            ...roles,
                        ]"
                    />
                </div>
                <Button
                    v-if="searchQuery || role"
                    variant="destructive"
                    @click="reset"
                    class="text-muted-foreground text-white"
                >
                    <X /> Réinitialiser
                </Button>
                <Modal title="Formulaire de création d'utilisateur">
                    <form @submit.prevent="submit">
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
                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
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

                            <InputError
                                class="mt-2"
                                :message="form.errors.role"
                            />
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

                            <InputError
                                class="mt-2"
                                :message="form.errors.role"
                            />
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

                            <InputError
                                class="mt-2"
                                :message="form.errors.role"
                            />
                        </div>

                        <div class="mt-4 flex justify-center">
                            <AlertDialogCancel :disabled="form.processing"
                                >Annuler</AlertDialogCancel
                            >
                            <AlertDialogAction
                                type="submit"
                                class="ml-3 bg-red-600"
                                :disabled="form.processing"
                                :class="{ 'opacity-50': form.processing }"
                            >
                                {{
                                    form.processing
                                        ? 'Validation...'
                                        : 'Valider'
                                }}
                            </AlertDialogAction>
                        </div>
                    </form>
                </Modal>
            </div>
        </div>

        <Table :rows="rows.meta.links">
            <TableHeader>
                <TableRow>
                    <TableHead> Id </TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Role</TableHead>
                    <TableHead>sexe</TableHead>
                    <TableHead>Change MDP</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Date </TableHead>
                    <TableHead>Action </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody v-if="filteredRows.length > 0">
                <TableRow v-for="row in filteredRows" :key="row.id">
                    <TableCell>{{ row.id }}</TableCell>
                    <TableCell>{{ row.email }}</TableCell>
                    <TableCell>{{ row.sexe }}</TableCell>
                    <TableCell>{{ row.role }}</TableCell>
                    <TableCell>
                        <Badge v-if="row.change_password">OUI</Badge>
                        <Badge variant="destructive" v-else>NON</Badge>
                    </TableCell>

                    <TableCell>
                        <Badge v-if="row.etat">Actif</Badge>
                        <Badge variant="destructive" v-else>Desactiver</Badge>
                    </TableCell>
                    <TableCell>{{ row.created_at }}</TableCell>
                    <TableCell class="flex">
                        <ButtonEdit
                            :href="UserController.edit({ id: row.id }).url"
                        />
                        <ButtonDelete
                            :href="UserController.destroy({ id: row.id }).url"
                        />
                    </TableCell>
                </TableRow>
            </TableBody>
            <TableBody v-else>
                <TableRow>
                    <TableCell colspan="5" class="text-center text-gray-500"
                        >Aucun user trouvé.
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </AppLayout>
</template>
