<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Navigation from '@/components/Navigation.vue';
import { stats } from '@/routes/stats';

defineProps({playerStats: Object})
</script>

<template>
    <Head title="Stats">
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
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                >
                    <div>
                        <h1 class="flex w-full items-center justify-center text-[16px] md:text-[28px] mb-10">Stats</h1>
                        <div class="flex cols-2 w-full border">
                            <Link
                                :href="stats({query: {'stats': 'player'}})"
                                class="rounded-tl-lg rounded-tr-lg p-6 mr-2 w-full text-[16px] md:text-[28px]"
                                :class="{ 'bg-neutral-700': $page.url === '/stats?stats=player' }"
                            >
                                Player
                            </Link>
                            <Link
                                :href="stats({query: {'stats': 'goalie'}})"
                                class="rounded-tl-lg rounded-tr-lg  p-6 ml-2 w-full text-[16px] md:text-[28px]"
                                :class="{ 'bg-neutral-700': $page.url === '/stats?stats=goalie' }"
                            >
                                Goalie
                            </Link>
                        </div>
                        <div class="overflow-x-scroll lg:overflow-x-auto">
                            <table class="table-auto w-full border border-neutral-50 lg:overflow-x-auto">
                                <thead>
                                    <tr class="bg-neutral-900">
                                        <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">Player</th>
                                        <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">Goals</th>
                                        <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">Assists</th>
                                        <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">Points</th>
                                        <th
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            Goals Against
                                        </th>
                                        <th
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            GAA
                                        </th>
                                        <th
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            Shots Against
                                        </th>
                                        <th
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            Save %
                                        </th>
                                        <th
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            Shutouts
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-neutral-900" v-for="player in playerStats" v-bind:key="player.player_id">
                                        <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">{{ player.player_name }} - {{ player.team_name }}</td>
                                        <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">{{ +player.goals }}</td>
                                        <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">{{ +player.assists }}</td>
                                        <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">{{ +player.goals + +player.assists }}</td>
                                        <td
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            {{ +player.goals_against }}
                                        </td>
                                        <td
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            {{ (+player.goals_against / +player.games_played).toFixed(2) }}
                                        </td>
                                        <td
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            {{ +player.shots_against }}
                                        </td>
                                        <td
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            {{ ((+player.shots_against - +player.goals_against) / (player.shots_against)).toFixed(3) }}
                                        </td>
                                        <td
                                            :class="{'hidden': $page.url !== '/stats?stats=goalie' }"
                                            class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2"
                                        >
                                            {{ +player.shutouts }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
