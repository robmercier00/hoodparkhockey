<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { dashboard, login, home, records, media, rules, about } from '@/routes';
import { rosters } from '@/routes/rosters';
import { schedule } from '@/routes/schedule';
import { standings } from '@/routes/standings';
import { stats } from '@/routes/stats';

</script>

<template>
    <button 
        data-toggle="collapse" 
        data-target="#collapseButton" 
        aria-expanded="false" 
        aria-controls="collapseButton" 
        class="md:fixed items-center justify-center border align-middle text-center transition-all duration-300 ease-in 
            disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full 
            data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-2 px-4 shadow-sm hover:shadow-md bg-slate-800 
            border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700"
    >
        ☰
    </button>
    <div class="md:fixed overflow-hidden md:w-50 bg-neutral-900 transition-[max-height] duration-300 ease-in-out max-h-0 mt-1 md:mt-12" id="collapseButton">
        <nav class="grid">
            <Link
                :href="home()"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                :class="{ 'active': $page.url === '/' }"
            >
                HPHL Home
            </Link>
            <Link
                :href="schedule()"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                :class="{ 'active': $page.url === '/schedule' }"
            >
                Schedule
            </Link>
            <Link
                :href="rosters()"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                :class="{ 'active': $page.url === '/rosters' }"
            >
                Rosters
            </Link>
            <Link
                :href="standings()"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                :class="{ 'active': $page.url === '/standings' }"
            >
                Standings
            </Link>
            <Link
                :href="records()"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                :class="{ 'active': $page.url === '/records' }"
            >
                Records
            </Link>
            <Link
                :href="stats()"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                :class="{ 'active': $page.url === '/stats' }"
            >
                Stats
            </Link>
            <Link
                :href="media()"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                :class="{ 'active': $page.url === '/media' }"
            >
                Media
            </Link>
            <Link
                :href="rules()"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                :class="{ 'active': $page.url === '/rules' }"
            >
                Rules
            </Link>
            <Link
                :href="about()"
                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                :class="{ 'active': $page.url === '/about' }"
            >
                About
            </Link>
            <Link
                v-if="$page.props.auth.user"
                :href="dashboard()"
                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
                Dashboard
            </Link>
            <template v-else>
                <Link
                    :href="login()"
                    class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    Admin Login
                </Link>
            </template>
        </nav>
    </div>
</template>

<style scoped></style>
