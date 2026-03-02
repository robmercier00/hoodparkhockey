<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard, home } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-y-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <h1 class="flex w-full items-center justify-center text-[16px] md:text-[28px] mb-10">Current Season(s)</h1>

                    <div v-for="season in seasons" v-bind:key="season.id">
                        <div v-if="season.current_season === 1" class="flex w-full items-center justify-center text-sm">
                            <Link
                                :href="home()"
                                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                            >
                                <span>{{ season.name }}&nbsp;&nbsp;&nbsp;&nbsp;{{ season.start_date }} - {{ season.end_date }}</span>
                            </Link>
                        </div>
                    </div>
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <h1 class="flex w-full items-center justify-center text-[16px] md:text-[28px] mb-10">Games Needing Stats</h1>
                    <div class="flex w-full items-center justify-center text-sm">
                        <Link
                            :href="home()"
                            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                            >
                                (recent games that need stats added)
                        </Link>
                    </div>                    
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <h1 class="flex w-full items-center justify-center text-[16px] md:text-[28px] mb-10">Players</h1>
                    <div class="flex w-full items-center justify-center text-sm">
                        <Link
                            :href="home()"
                            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                            >
                                Add Player
                        </Link>
                    </div>
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <h1 class="flex w-full items-center justify-center text-[16px] md:text-[28px] mb-10">All Seasons</h1>
                <div v-for="season in seasons" v-bind:key="season.id">
                    <div class="flex w-full items-center md:justify-center text-sm">
                        <Link
                            :href="home()"
                            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                            >
                                {{ season.name }}
                        </Link>
                    
                        {{ season.start_date }} - {{ season.end_date }}
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script lang="ts">
import axios from 'axios';

export default {
    name: 'Seasons',
    data() {
        return {
            seasons: [{id: 0, name: 'New Season', start_date: null, end_date: null, current_season: null}],
        };
    },
    methods: {
        async fetchSeasons() {
            try {
                const response = await axios.get('/seasons', {
                    params: {},
                });

                this.seasons = response.data;
            } catch (error) {
                console.error('Error fetching announcements:', error);
            }
        },
    },
    mounted() {
        this.fetchSeasons();
    },
};
</script>