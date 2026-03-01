<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import Navigation from '@/components/Navigation.vue';

defineProps({ schedule: Object });
</script>

<template>
    <Head title="Schedule">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center p-6 text-[#1b1b18] lg:justify-center lg:p-8"
    >
        <aside class="mb-6 w-full text-sm not-has-[nav]:hidden">
            <Navigation />
        </aside>

        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
            <main
                class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg xl:max-w-6xl lg:flex-row"
            >
                <div
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[11px] md:text-[16px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                >
                    <div class="md:mb-12 mb-6" v-for="(gameDay, rosters) in schedule" v-bind:key="rosters">
                        <h1 class="flex w-full items-center justify-center text-[16px] md:text-[28px] mb-10">Schedule - {{ rosters }}</h1>
                        <table class="table-auto w-full border border-neutral-50">
                            <thead>
                                <tr class="bg-neutral-900">
                                    <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2 w-1/6">Time</th>
                                    <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">Home Team</th>
                                    <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">Away Team</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-neutral-900" v-for="(game) in gameDay" v-bind:key="game.game_date_time">
                                    <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2 w-1/6">{{ game.game_time }}</td>
                                    <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">{{ game.home_team }}</td>
                                    <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">{{ game.away_team }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>

