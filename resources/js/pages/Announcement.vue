<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { create } from '@/routes/announcements';
import { type BreadcrumbItem } from '@/types';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

</script>

<template>
    <Head title="Create Announcement" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Form
                v-bind="create.form()"
                v-slot="{ errors, processing }"
                class="flex flex-col gap-6"
            >
                <div class="grid gap-6 items-center justify-center">
                    <div class="grid gap-2 inline-flex">
                        <div>
                            <Label for="announcement">Announcement</Label>
                            <Input
                                id="announcement"
                                type="text"
                                required
                                name="announcement"
                                :model-value="announcement"
                                autofocus
                                :disabled="isUpdate"
                                :tabindex="1"
                            />
                            <InputError :message="errors.announcement" />
                    
                            <Input
                                name="announcementId"
                                :model-value="announcementId"
                                v-if="isUpdate"
                                hidden
                            />
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
                        {{ buttonAction }} Announcement
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
            announcement: '',
            buttonAction: 'Create',
            isUpdate: false
        }
    },
    methods: {
        async getQueryParams() {
            let queryString = this.$page.url;

            if (queryString.indexOf("?") === -1) {
                return {};
            }

            queryString = queryString.substring(queryString.indexOf("?") + 1);
            
            if (queryString.indexOf("announcement_id=") === -1) {
                return {};
            }

            const announcementId = queryString.substring(queryString.indexOf("announcement_id=") + 10);

            if (parseInt(announcementId) > 0) {
                try {
                    const response = await axios.get("/single-announcement", {
                        params: { id: announcementId }
                    });

                    this.isUpdate = true;
                    this.announcement = response.data[0].announcement;

                    this.buttonAction = "Update";

                    for (let i = 1; i <= parseInt(response.data[0].numTeams); i++) {
                        // const parsedTeamName = 'teamName' + i;
                        // const parsedTeamColor = 'teamColor' + i;
                        // const parsedTeamId = 'teamId' + i;
                        // this.waitForElement('#team' + i, (element) => {
                        //     element.value = response.data[0][parsedTeamName];
                        // });

                        // this.waitForElement('#team' + i + 'color', (element) => {
                        //     element.value = response.data[0][parsedTeamColor];
                        // });

                        // this.waitForElement('#team' + i + 'id', (element) => {
                        //     element.value = response.data[0][parsedTeamId];
                        // });
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
        }
    },
    mounted() {
        this.getQueryParams();
    }
}

</script>