<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import {
    SidebarMenu,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import UserMenuContent from './UserMenuContent.vue';

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem> 
            <UserMenuContent :user="user" />
        </SidebarMenuItem>
    </SidebarMenu>
</template>
