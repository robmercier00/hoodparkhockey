
<template>
    <h1 class="flex w-full items-center justify-center text-[16px] md:text-[28px] mb-10 mt-10">Schedule - {{ gameDate }}</h1>
    <table class="table-auto w-full border border-neutral-50">
        <thead>
            <tr class="bg-neutral-900">
                <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2 w-1/6">Time</th>
                <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">Home Team</th>
                <th class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">Away Team</th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-neutral-900" v-for="game in schedule" v-bind:key="game.game_date_time">
                <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2 w-1/6">{{ game.game_time }}</td>
                <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">{{ game.home_team }}</td>
                <td class="text-[11px] md:text-[15px] border-1 border-neutral-600 px-4 py-2">{{ game.away_team }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">
import axios from "axios";

export default {
    name: "Schedule",
    props: {
        period: {
            type: String,
            required: false,
            default: 'season'
        }
    },
    data() {
        return {
            schedule: [],
            gameDate: "",
        };
    },
    methods: {
        async fetchSchedule() {
            try {
                const response = await axios.get("/latest-schedule", {
                    params: { period: this.period }
                });

                this.gameDate = response.data[0].game_day;

                response.data.forEach((game: object) => {
                    this.schedule.push(game);
                })
            } catch (error) {
                console.error("Error fetching schedule:", error);
            }
        },
    },
    mounted() {
        this.fetchSchedule();
    }
};
</script>
