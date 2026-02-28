<template>
    <h1 class="mb-10 flex w-full items-center justify-center text-[16px] md:text-[28px]">
        Announcements
    </h1>
    <div v-for="announcement in announcements" v-bind:key="announcement.id">
        <div class="mb-8 flex text-[16px] md:text-[22px]">
            {{ announcement.created_at }}
        </div>
        <div
            class="ml-12 flex text-[11px] md:text-[15px]"
            v-html="announcement.announcement"
        ></div>
    </div>
</template>

<script lang="ts">
import axios from 'axios';

export default {
    name: 'Announcements',
    data() {
        return {
            announcements: [{id: null, created_at: null, announcement: null}],
        };
    },
    methods: {
        async fetchAnnouncements() {
            try {
                const response = await axios.get('/latest-announcements', {
                    params: {},
                });

                response.data.forEach((announcement: object) => {
                    announcement.created_at = new Intl.DateTimeFormat(
                        this.locale,
                        {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                        },
                    ).format(new Date(announcement.created_at));

                    this.announcements.push(announcement);
                });
            } catch (error) {
                console.error('Error fetching announcements:', error);
            }
        },
    },
    mounted() {
        this.fetchAnnouncements();
    },
};
</script>
