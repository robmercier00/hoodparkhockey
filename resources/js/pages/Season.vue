<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { teamPlayers } from '@/routes';
import { createSeason } from '@/routes/seasons';
import { type BreadcrumbItem } from '@/types';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

</script>

<template>
    <Head title="Create Season" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Form
                v-bind="createSeason.form()"
                v-slot="{ errors, processing }"
                class="flex flex-col gap-6"
            >
                <div class="grid gap-6 items-center justify-center">
                    <div class="grid gap-2 md:inline-flex">
                        <div>
                            <Label for="season-name">Season Name</Label>
                            <Input
                                id="season-name"
                                type="text"
                                required
                                name="seasonName"
                                :model-value="seasonName"
                                autofocus
                                :disabled="isUpdate"
                                :tabindex="1"
                                placeholder="Spring 2007 Thursdays"
                                @blur="setSeasonName"
                            />
                            <InputError :message="errors.season" />
                    
                            <Input
                                name="seasonName"
                                :model-value="seasonName"
                                v-if="isUpdate"
                                hidden
                            />
                        </div>

                        <div>
                            <Label for="num-teams">Number of Teams</Label>
                            <Input
                                id="num-teams"
                                type="integer"
                                required
                                name="numTeams"
                                :model-value="numTeams"
                                :tabindex="2"
                                placeholder="6"
                                @blur="setNumberOfTeams"
                            />
                            <InputError :message="errors.teams" />
                    
                        </div>
                    </div>

                    <div class="grid gap-4 md:inline-flex">
                        <div>
                            <Label for="start-date">Start Date</Label>
                            <Input
                                id="start-date"
                                type="date"
                                required
                                name="startDate"
                                :model-value="startDate"
                                :tabindex="3"
                                placeholder="4/20/2007"
                            />
                            <InputError :message="errors.startDate" />
                    
                        </div>

                        <div>
                            <Label for="end-date">End Date</Label>
                            <Input
                                id="end-date"
                                type="date"
                                required
                                name="endDate"
                                :model-value="endDate"
                                :tabindex="4"
                                placeholder="6/26/2007"
                            />
                            <InputError :message="errors.endDate" />
                    
                        </div>

                        <div>
                            <Label for="current-season" class="block">
                                <span class="block pb-4">Current Season?</span>
                                <Checkbox class="ml-12" id="current-season" name="currentSeason" :model-value="currentSeason" @click="currentSeason = !currentSeason" :tabindex="5" />
                            </Label>
                        </div>
                    </div>

                    <div>
                        <h1 v-if="seasonName" class="flex w-full items-center justify-center text-[11px] md:text-[22px] mb-4 mt-4">Teams - {{ seasonName }}</h1>
                        <div class="grid gap-2">
                            <div class="grid gap-2 inline-flex opacity-100 transition-opacity duration-750" v-for="n in numTeams" v-bind:key="n">
                                <Input
                                    :id="'team' + n + 'id'"
                                    type="number"
                                    hidden
                                    :name="'teamId' + n"
                                />

                                <Input
                                    :id="'team' + n"
                                    type="string"
                                    required
                                    :name="'teamName' + n"
                                    :placeholder="'Team ' + n + ' name'"
                                />

                                <Input
                                    :id="'team' + n + 'color'"
                                    type="string"
                                    required
                                    :name="'teamColor' + n"
                                    :placeholder="'Team ' + n + ' color'"
                                />

                                <Link
                                    :href="teamPlayers({query: {'team_id': n, 'season_id': seasonId}})"
                                    class="flex rounded-sm border w-full px-4 py-1.5 text-sm leading-normal text-primary-foreground bg-primary hover:border-[#19140035]"
                                >
                                    Players
                                </Link>
                            </div>
                            
                        </div>
                    </div>

                    <Button
                        type="submit"
                        class="mt-4 w-full flex"
                        :tabindex="6"
                        :disabled="processing"
                        data-test="season-button"
                    >
                        <Spinner v-if="processing" />
                        {{ buttonAction }} Season
                    </Button>
                </div>
            </Form>
        </div>
    </AppLayout>
</template>

<script lang="ts">
import axios from "axios";

export default {
    data() {
        return {
            seasonName: '',
            numTeams: 6,
            startDate: '',
            endDate: '',
            currentSeason: true,
            showTeams: false,
            buttonAction: 'Create',
            isUpdate: false,
            seasonId: ''
        }
    },
    methods: {
        setSeasonName(event: any) {
            if (event.target.value.trim().length > 0) {
                this.seasonName = event.target.value.trim();
            }
        },
        setNumberOfTeams(event: any) {
            if (parseInt(event.target.value.trim()) > 0) {
                this.numTeams = parseInt(event.target.value.trim());
            }
        },
        async getQueryParams() {
            let queryString = this.$page.url;

            if (queryString.indexOf("?") === -1) {
                return {};
            }

            queryString = queryString.substring(queryString.indexOf("?") + 1);
            
            if (queryString.indexOf("season_id=") === -1) {
                return {};
            }

            const seasonId = queryString.substring(queryString.indexOf("season_id=") + 10);

            if (parseInt(seasonId) > 0) {
                try {
                    this.seasonId = seasonId;

                    const response = await axios.get("/single-season", {
                        params: { id: seasonId }
                    });

                    this.isUpdate = true;
                    this.seasonName = response.data[0].seasonName;
                    this.numTeams = response.data[0].numTeams;
                    this.startDate = response.data[0].startDate;
                    this.endDate = response.data[0].endDate;
                    this.currentSeason = response.data[0].currentSeason === 1 ? true : false;
                    this.showTeams = true;
                    this.buttonAction = "Update";

                    for (let i = 1; i <= parseInt(response.data[0].numTeams); i++) {
                        const parsedTeamName = 'teamName' + i;
                        const parsedTeamColor = 'teamColor' + i;
                        const parsedTeamId = 'teamId' + i;
                        this.waitForElement('#team' + i, (element) => {
                            element.value = response.data[0][parsedTeamName];
                        });

                        this.waitForElement('#team' + i + 'color', (element) => {
                            element.value = response.data[0][parsedTeamColor];
                        });

                        this.waitForElement('#team' + i + 'id', (element) => {
                            element.value = response.data[0][parsedTeamId];
                        });
                    }
                } catch (error) {
                    console.error("Error fetching season:", error);
                }
            }
        },
        waitForElement(selector, callback) {
            const observer = new MutationObserver((mutations, observer) => {
                const element = document.querySelector(selector);
                if (element) {
                    observer.disconnect();
                    callback(element);
                }
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true,
            });
        },
        teamPlayers(teamId: string) {
            
        }
    },
    mounted() {
        this.getQueryParams();
    }
}

</script>