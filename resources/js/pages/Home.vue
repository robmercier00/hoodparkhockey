<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import Announcements from '@/components/Announcements.vue';
import Navigation from '@/components/Navigation.vue';
import Schedule from '@/components/WeekSchedule.vue';

</script>

<template>
    <Head title="">
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
                    <Announcements />
                    <Schedule period="week" />
                </div>

            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
