<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
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
                    <div class="grid gap-2 inline-flex">
                        <div>
                            <Label for="season-name">Season Name</Label>
                            <Input
                                id="season-name"
                                type="text"
                                required
                                name="seasonName"
                                :model-value="seasonName"
                                autofocus
                                :tabindex="1"
                                placeholder="Spring 2007 Thursdays"
                                @blur="setSeasonName"
                            />
                            <InputError :message="errors.season" />
                    
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

                    <div class="grid gap-4 inline-flex">
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
                            <div class="grid gap-2 inline-flex" v-for="n in numTeams" v-bind:key="n">
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
                        Create Season
                    </Button>
                </div>
            </Form>
        </div>
    </AppLayout>
</template>

<script lang="ts">
export default {
    data() {
        return {
            seasonName: '',
            numTeams: '',
            startDate: '',
            endDate: '',
            currentSeason: true,
            showTeams: false
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
        }
    }
}

</script>