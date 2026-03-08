<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
import {
} from '@/components/ui/dropdown-menu';
import { logout } from '@/routes';

const handleLogout = () => {
    router.flushAll();
};

</script>

<template>
    <div class="flex w-full items-center justify-center">
        <Link
            class="contents w-full cursor-pointer"
            :href="logout()"
            @click="handleLogout"
            as="button"
            data-test="logout-button"
        >
            <LogOut class="mr-2 h-4 w-4" />
            Log out
        </Link>
    </div>
</template>
