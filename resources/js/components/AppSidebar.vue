<script setup lang="ts">
import { Badge, Calendar, ChartBar, ChartBarStacked, ClipboardPenLineIcon, Contact, Home, LayoutGrid, MedalIcon, PersonStanding, VideoIcon } from 'lucide-vue-next';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
} from '@/components/ui/sidebar';
import { dashboard, home, media, rules, about } from '@/routes';
import { records } from '@/routes/records';
import { rosters } from '@/routes/rosters';
import { schedule } from '@/routes/schedule';
import { standings } from '@/routes/standings';
import { stats } from '@/routes/stats';
import { type NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'HPHL Home',
        href: home(),
        icon: Home,
    },
    {
        title: 'Schedule',
        href: schedule(),
        icon: Calendar
    },
    {
        title: 'Rosters',
        href: rosters(),
        icon: Contact,
    },
    {
        title: 'Standings',
        href: standings(),
        icon: ChartBar,
    },
    {
        title: 'Records',
        href: records(),
        icon: MedalIcon,
    },
    {
        title: 'Stats',
        href: stats(),
        icon: ChartBarStacked,
    },
    {
        title: 'Media',
        href: media(),
        icon: VideoIcon,
    },
    {
        title: 'Rules',
        href: rules(),
        icon: ClipboardPenLineIcon,
    },
    {
        title: 'About',
        href: about(),
        icon: PersonStanding,
    },
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [

];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
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
