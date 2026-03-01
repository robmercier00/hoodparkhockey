<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Navigation from '@/components/Navigation.vue';

defineProps({records: Object});
</script>

<template>
    <Head title="Records">
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
                    <h1 class="flex w-full items-center justify-center text-[16px] md:text-[28px] mb-10">All-Time Records</h1>
                    <div class="md:mb-12 mb-6" v-for="(allTimeRecord, recordName) in records" v-bind:key="recordName">
                        <h1 class="flex w-full text-[11px] md:text-[22px] mb-2">{{ recordName }}</h1>
                        <div class="mb-6" v-for="record in allTimeRecord" v-bind:key="record.player_team_name">
                            <span class="text-[11px] md:text-[18px] ml-8">{{ record[0] }}&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                            <span class="text-[11px] md:text-[18px]">  {{ record[1].replace(';', ', ') }},&nbsp;&nbsp;</span>
                            <span class="text-[11px] md:text-[18px]">{{ record[2] }}</span>
                        </div>
                    </div>
                </div>

            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
