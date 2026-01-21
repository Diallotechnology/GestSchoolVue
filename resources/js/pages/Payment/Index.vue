<script setup lang="ts">
import ClasseController from '@/actions/App/Http/Controllers/ClasseController';
import ButtonDelete from '@/components/ButtonDelete.vue';
import ButtonEdit from '@/components/ButtonEdit.vue';
import InputError from '@/components/InputError.vue';
import Modal from '@/components/Modal.vue';
import Pagination from '@/components/Pagination.vue';
import Select2 from '@/components/Select2.vue';
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
import { Filiere, Matiere } from '@/types/models';
import { Head, useForm } from '@inertiajs/vue3';
import { SearchIcon, X } from 'lucide-vue-next';
import { computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'liste des classes',
        href: '/classe',
    },
];

interface Row {
    id: number;
    reference: string;
    type: string;
    mode: string;
    adresse: string;
    motif: string;
    montant: number;
    remise: number;
    remise_motif: string;
    classe: {
        id: number;
        nom: string;
    };
    user: {
        id: number;
        name: string;
        email: string;
    };
    student: {
        id: number;
        nom: string;
        prenom: string;
        reference: string;
    };

    created_at: string;
}

const form = useForm({
    reference: '',
    type: '',
    mode: '',
    adresse: '',
    motif: '',
    montant: 0,
    remise: 0,
    remise_motif: '',
    classe_id: '',
    student_id: '',
});

const submit = () => {
    form.post(Payc.store().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const props = defineProps<{
    rows: PaginatedData<Row>;
    filieres: Filiere[];
    matieres: Matiere[];
}>();

const { filters, reset } = useDynamicFilters(
    {
        search: '',
    },
    {
        controller: ClasseController, // ✅ Wayfinder
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
                    <TableHead>nom</TableHead>
                    <TableHead>scolarite</TableHead>
                    <TableHead>frais</TableHead>
                    <TableHead>filiere</TableHead>
                    <TableHead>matieres </TableHead>
                    <TableHead>date de creation </TableHead>
                    <TableHead>Action </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody v-if="filteredRows.length > 0">
                <TableRow v-for="row in filteredRows" :key="row.id">
                    <TableCell>{{ row.id }}</TableCell>
                    <TableCell>{{ row.nom }}</TableCell>
                    <TableCell>{{ row.scolarite }}</TableCell>
                    <TableCell>{{ row.frais }}</TableCell>
                    <TableCell>{{ row.filiere.nom }}</TableCell>
                    <TableCell>
                        <div
                            v-for="(item, index) in row.matieres || []"
                            :key="index"
                            class="flex items-center gap-1"
                        >
                            <span>{{ item }}</span>
                        </div>
                    </TableCell>
                    <TableCell>{{ row.created_at }}</TableCell>
                    <TableCell class="flex">
                        <ButtonEdit
                            :href="ClasseController.edit({ id: row.id }).url"
                        />
                        <ButtonDelete
                            :href="ClasseController.destroy({ id: row.id }).url"
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
