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
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden xl:max-w-6xl">
            <Navigation />
        </header>

        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
            <main
                class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg xl:max-w-6xl lg:flex-row"
            >
                <div
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                >
                    <div v-for="(gameDay, rosters) in schedule" v-bind:key="index">
                        <h1 class="flex w-full items-center justify-center text-[28px] mb-10 mt-10">Schedule - {{ rosters }}</h1>
                        <table class="table-auto w-full border border-neutral-50">
                            <thead>
                                <tr class="bg-neutral-900">
                                    <th class="border-1 border-neutral-600 px-4 py-2 w-1/6">Time</th>
                                    <th class="border-1 border-neutral-600 px-4 py-2">Home Team</th>
                                    <th class="border-1 border-neutral-600 px-4 py-2">Away Team</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-neutral-900" v-for="(game) in gameDay" v-bind:key="game.game_date_time">
                                    <td class="border-1 border-neutral-600 px-4 py-2 w-1/6">{{ game.game_time }}</td>
                                    <td class="border-1 border-neutral-600 px-4 py-2">{{ game.home_team }}</td>
                                    <td class="border-1 border-neutral-600 px-4 py-2">{{ game.away_team }}</td>
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

<script lang="ts">
// export default function getGameTime(game_date_time: string) {
//     return new Date(game_date_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
// }

</script>
