<script setup lang="ts">
import DepenseController from '@/actions/App/Http/Controllers/DepenseController';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Form, Head, Link, router } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Modifier depense',
        href: '/depense/edit',
    },
];

const props = defineProps<{
    depense: {
        id: number;
        libelle: string;
        montant: number;
    };
}>();
</script>

<template>
    <Head title="Modifier période" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card class="mx-auto space-y-6 lg:w-2/3">
            <CardTitle>
                <div class="my-2 text-center text-2xl">
                    Formulaire de mise à jour
                </div>
            </CardTitle>
            <CardContent class="justify-center p-4">
                <Form
                    :action="DepenseController.update(props.depense.id)"
                    method="post"
                    @finish="
                        () =>
                            router.reload({
                                only: ['depense'],
                            })
                    "
                    v-slot="{ errors, processing }"
                    class="flex flex-col gap-6"
                >
                    <div class="grid gap-2">
                        <Label for="name">Nom</Label>
                        <Input
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            name="libelle"
                            required
                            :defaultValue="props.depense.libelle"
                            placeholder="libelle de la depense"
                        />
                        <InputError class="mt-2" :message="errors.libelle" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="montant">montant</Label>
                        <Input
                            id="montant"
                            type="text"
                            class="mt-1 block w-full"
                            name="montant"
                            :defaultValue="props.depense.montant"
                            required
                            placeholder="montant de la dépense"
                        />
                        <InputError class="mt-2" :message="errors.montant" />
                    </div>

                    <div class="mt-4 flex justify-center">
                        <Link
                            :href="DepenseController.index().url"
                            class="mx-3"
                        >
                            <Button variant="destructive" :disabled="processing"
                                >Annuler</Button
                            >
                        </Link>
                        <Button
                            type="submit"
                            class="ml-3"
                            :disabled="processing"
                            :class="{ 'opacity-50': processing }"
                        >
                            {{ processing ? 'Validation...' : 'Valider' }}
                        </Button>
                    </div>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
