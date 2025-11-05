<script setup lang="ts">
import ClasseController from '@/actions/App/Http/Controllers/ClasseController';
import DepenseController from '@/actions/App/Http/Controllers/DepenseController';
import FiliereController from '@/actions/App/Http/Controllers/FiliereController';
import MatiereController from '@/actions/App/Http/Controllers/MatiereController';
import PeriodeController from '@/actions/App/Http/Controllers/PeriodeController';
import TeacherController from '@/actions/App/Http/Controllers/TeacherController';
import TuteurController from '@/actions/App/Http/Controllers/TuteurController';
import TypeController from '@/actions/App/Http/Controllers/TypeController';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { AppPageProps, type NavItem } from '@/types';
import flasher from '@flasher/flasher';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Filiere',
        href: FiliereController.index().url,
        icon: LayoutGrid,
    },
    {
        title: 'Periode',
        href: PeriodeController.index().url,
        icon: LayoutGrid,
    },
    {
        title: 'Matiere',
        href: MatiereController.index().url,
        icon: LayoutGrid,
    },
    {
        title: 'Classe',
        href: ClasseController.index().url,
        icon: LayoutGrid,
    },
    {
        title: 'Professeur',
        href: TeacherController.index().url,
        icon: LayoutGrid,
    },
    {
        title: 'type',
        href: TypeController.index().url,
        icon: LayoutGrid,
    },
    {
        title: 'depense',
        href: DepenseController.index().url,
        icon: LayoutGrid,
    },
    {
        title: 'tuteur',
        href: TuteurController.index().url,
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];

// Récup user
const page = usePage<AppPageProps>();
// Messages flash
const localMessages = ref<Record<string, any>>({});
watch(
    computed(() => page.props.messages),
    (value) => {
        if (value && Object.keys(value).length > 0) {
            localMessages.value = { ...value };
            flasher.render(localMessages.value);
            localMessages.value = {};
        }
    },
    { immediate: true },
);
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
