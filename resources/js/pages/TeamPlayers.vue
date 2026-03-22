<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard,season } from '@/routes';
import { player, teamPlayers } from '@/routes/teamPlayers';
import { type BreadcrumbItem } from '@/types';
import { CircleMinus } from "lucide-vue-next";

const pageUrl = location.href;
const params = new URLSearchParams(new URL(pageUrl).search);
const season_id = params.get("season_id");

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Season',
        href: season({query: {"season_id": season_id}}).url
    },
    {
        title: 'Team Players',
    }
];

</script>

<template>
    <Head title="Team Players" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Form
                v-bind="teamPlayers.form()"
                v-slot="{ processing }"
                class="flex flex-col gap-6"
            >
                <div class="grid gap-6 items-center justify-center">
                    <div class="grid gap-2 md:inline-grid">
                        <h1 class="mb-8">{{ seasonName }} - {{ teamName }}</h1>

                        <div class="mb-4 grid gap-4">
                            <Input
                                type="number"
                                hidden
                                v-model:model-value="teamId"
                                name="team_id"
                            />
                            <div class="inline-flex grid" v-for="(player, index) in teamPlayerNames" v-bind:key="player.id">
                                <div class="block">
                                    <Label :for="'player_' + player.id">Player Name</Label>
                                    <Input
                                        :id="'player_' + player.id"
                                        type="number"
                                        hidden
                                        v-model:model-value="player.id"
                                        :name="'player_' + index"
                                    />

                                    <Input
                                        :id="'player' + player.id"
                                        type="string"
                                        disabled
                                        v-model:model-value="player.name"
                                        :name="'player_name' + player.id"
                                    />
                                </div>
                                <div class="block ml-4">
                                    <Label :for="'player_' + player.id + '-is_goalie'">Is Goalie?</Label>
                                    <Checkbox
                                        class="mt-3 ml-4"
                                        :id="'player_' + player.id + '-is_goalie'"
                                        :name="'player_' + index + '-is_goalie'"
                                        :model-value="!!player.is_goalie"
                                        @click="player.is_goalie = !player.is_goalie"
                                    />
                                </div>

                                <div class="cursor-pointer block ml-4" @click="removePlayer(player)">
                                    <Label :for="'player_' + player.id + '_remove'">Remove</Label>
                                    <CircleMinus class="mt-1 ml-4" :id="'player_' + player.id + '_remove'" />
                                </div>

                            </div>

                        </div>
                    </div>

                    <Button
                        type="submit"
                        class="mb-8 w-full flex"
                        :tabindex="6"
                        :disabled="processing || !teamPlayerNames.length"
                        data-test="season-button"
                    >
                        <Spinner v-if="processing" />
                        Save Players
                    </Button>
                </div>
            </Form>
            <div class="grid gap-6 items-center justify-center">
                <div class="grid gap-2 md:inline-grid">
                    <div class="contents">
                        <Label for="player-name">Add Player</Label>
                        <Input
                            id="player-name"
                            type="text"
                            required
                            name="playerName"
                            v-model="playerNameSearch"
                            autofocus
                            :tabindex="1"
                            placeholder="Start Typing to Search"
                            @input="findPlayerByName"
                        />

                        <div v-if="playerSearch.length" class="dropdown">
                            <div
                                v-for="option in playerSearch"
                                :key="option"
                                @mousedown.prevent="selectOption(option)"
                            >
                                {{ option.name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

<script lang="ts">
import axios from "axios";

export default {
    data() {
        return {
            seasonId: 0,
            seasonName: '',
            teamId: 0,
            teamName: '',
            teamPlayerNames: [],
            playerSearch: [],
            playerNameSearch: ''
        }
    },
    methods: {
        async getQueryParams() {
            const pageUrl = location.href;

            const params = new URLSearchParams(new URL(pageUrl).search);

            const seasonId = params.get("season_id");
            const teamId = params.get("team_id");

            if (!seasonId || !teamId) {
                return {};
            }


            try {
                this.seasonId = parseInt(seasonId);

                const response = await axios.get("/getTeamPlayers", {
                    params: { seasonId: seasonId, teamId: teamId }
                });

                this.teamId = response.data[0].id;
                this.teamName = response.data[0].name;
                this.seasonName = response.data[0].seasonName;
                this.teamPlayerNames = response.data[0].teamPlayers;
            } catch (error) {
                console.error("Error fetching team players: ", error);
            }
        },
        async findPlayerByName(event: any) {
            const playerNameSearch = event.target.value;

            if (playerNameSearch.length > 2) {
                this.playerNameSearch = playerNameSearch;
                const playerResponse = await axios.get("/player", {
                    params: { playerName: playerNameSearch }
                });

                if (playerResponse?.data) {
                    this.playerSearch = playerResponse?.data;
                }
            }
        },
        selectOption(option: object) {
            this.teamPlayerNames.push(option);
            this.playerNameSearch = '';
            this.playerSearch = [];
        },
        removePlayer(player) {
            const playerIndex = this.teamPlayerNames.indexOf(player);

            if (playerIndex !== -1) {
                this.teamPlayerNames.splice(playerIndex, 1);
            }
        }
    },
    mounted() {
        this.getQueryParams();
    }
}
</script>
