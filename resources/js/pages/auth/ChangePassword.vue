<script setup lang="ts">
import PasswordChangeController from '@/actions/App/Http/Controllers/Settings/PasswordChangeController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    email: string;
}>();
</script>

<template>
    <AuthLayout
        title="Réinitialiser le mot de passe 🔒"
        description=" Lors de votre première connexion, veuillez changer votre mot de passe pour des raisons de sécurité. Suivez les critères ci-dessus et
            soumettez le formulaire."
    >
        <Head title="Changement de Mot de Passe Requis 🔒" />
        <p>
            Votre compte sera accessible avec le nouveau mot de passe. <br />
            NB: Utilisez au moins huit (8) caractères, mélangez majuscules,
            minuscules, chiffres et caractères spéciaux.
        </p>

        <Form
            v-bind="PasswordChangeController.store.form()"
            :transform="(data) => ({ ...data, email })"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="password">Mot de passe</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        autofocus
                        placeholder="Mot de passe"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation"
                        >Confirmer le mot de passe</Label
                    >
                    <Input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        placeholder="Confirmer le mot de passe"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full"
                    :disabled="processing"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />
                    Réinitialiser le mot de passe
                </Button>
            </div>
        </Form>
    </AuthLayout>
</template>
