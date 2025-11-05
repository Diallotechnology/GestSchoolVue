<script setup lang="ts">
import TeacherController from '@/actions/App/Http/Controllers/TeacherController';
import ButtonDelete from '@/components/ButtonDelete.vue';
import ButtonEdit from '@/components/ButtonEdit.vue';
import InputError from '@/components/InputError.vue';
import Modal from '@/components/Modal.vue';
import Pagination from '@/components/Pagination.vue';
import SelectTag from '@/components/SelectTag.vue';
import AlertDialogAction from '@/components/ui/alert-dialog/AlertDialogAction.vue';
import AlertDialogCancel from '@/components/ui/alert-dialog/AlertDialogCancel.vue';
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
import type { BreadcrumbItem, PaginatedData } from '@/types';
import { Classe, Matiere } from '@/types/models';
import { Head, useForm } from '@inertiajs/vue3';
import { SearchIcon, X } from 'lucide-vue-next';
import { computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'liste des professeurs',
        href: '/teacher',
    },
];

interface Row {
    id: number;
    nom: string;
    prenom: string;
    contact: string;
    matieres: {
        id: number;
        nom: string;
    };
    classes: {
        id: number;
        nom: string;
    };
    created_at: string;
}

const form = useForm({
    nom: '',
    prenom: '',
    contact: '',
    matiere_id: [],
    classe_id: [],
});

const submit = () => {
    form.post(TeacherController.store().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const props = defineProps<{
    rows: PaginatedData<Row>;
    matieres: Matiere[];
    classes: Classe[];
}>();

const { filters, reset } = useDynamicFilters(
    {
        search: '',
    },
    {
        controller: TeacherController, // ✅ Wayfinder
        debounceKeys: ['search'],
        delay: 300,
        persist: true,
    },
);
const searchQuery = useVModelRef(filters.search);

const filteredRows = computed(() => {
    return props.rows.data;
});
</script>
<template>
    <Head title="Liste des classes" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-wrap items-center justify-between gap-4 p-4">
            <!-- Barre de recherche et filtre -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Input de recherche -->
                <div class="relative w-70">
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

                <!-- Bouton Reset filtre -->
                <Button
                    v-if="searchQuery"
                    variant="destructive"
                    @click="reset"
                    class="text-muted-foreground text-white"
                >
                    <X />
                    Réinitialiser
                </Button>
            </div>

            <Modal title="Formulaire de nouvelle classe">
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
                        <AlertDialogCancel :disabled="form.processing"
                            >Annuler</AlertDialogCancel
                        >
                        <AlertDialogAction
                            type="submit"
                            class="mx-3"
                            :disabled="form.processing"
                            :class="{ 'opacity-50': form.processing }"
                        >
                            {{ form.processing ? 'Validation...' : 'Valider' }}
                        </AlertDialogAction>
                    </div>
                </form>
            </Modal>
        </div>
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead> Id </TableHead>
                    <TableHead>prenom</TableHead>
                    <TableHead>nom</TableHead>
                    <TableHead>contact</TableHead>
                    <TableHead>matieres </TableHead>
                    <TableHead>classes </TableHead>
                    <TableHead>date de creation </TableHead>
                    <TableHead>Action </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody v-if="filteredRows.length > 0">
                <TableRow v-for="row in filteredRows" :key="row.id">
                    <TableCell>{{ row.id }}</TableCell>
                    <TableCell>{{ row.prenom }}</TableCell>
                    <TableCell>{{ row.nom }}</TableCell>
                    <TableCell>{{ row.contact }}</TableCell>
                    <TableCell>
                        <div
                            v-for="(item, index) in row.matieres || []"
                            :key="index"
                            class="flex items-center gap-1"
                        >
                            <span>{{ item }}</span>
                        </div>
                    </TableCell>

                    <TableCell>
                        <div
                            v-for="(item, index) in row.classes || []"
                            :key="index"
                            class="flex items-center gap-1"
                        >
                            <span>{{ item }}</span>
                        </div>
                    </TableCell>
                    <TableCell>{{ row.created_at }}</TableCell>
                    <TableCell class="flex">
                        <ButtonEdit
                            :href="TeacherController.edit({ id: row.id }).url"
                        />
                        <ButtonDelete
                            :href="
                                TeacherController.destroy({ id: row.id }).url
                            "
                        />
                    </TableCell>
                </TableRow>
            </TableBody>
            <TableBody v-else>
                <TableRow>
                    <TableCell colspan="5" class="text-center text-gray-500"
                        >Aucun resultat trouvé.
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <div>
            <Pagination :links="rows.meta.links" class="my-2" />
        </div>
    </AppLayout>
</template>
