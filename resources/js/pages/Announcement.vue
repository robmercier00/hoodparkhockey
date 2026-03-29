<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { create } from '@/routes/announcements';
import { type BreadcrumbItem } from '@/types';
import '@vueup/vue-quill/dist/vue-quill.snow.css';


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
                @submit.prevent="handleSubmit"
            >
                <div class="gap-6 md:pl-28 md:pr-28 items-center justify-center">
                    <div class="gap-2 inline">
                        <div>
                            <Label class="mb-3" for="announcement-editor">Announcement</Label>
                            <QuillEditor
                                id="announcement-editor" 
                                v-model:content="announcement"
                                contentType="html"
                                theme="snow" 
                                toolbar="minimal" 
                            />
                            <input hidden="hidden" name="announcement" type="text" v-model="announcement" /> 
                            <input hidden="hidden" name="announcement_id" type="number" v-model="announcementId" />
                            <InputError :message="errors.announcement" />
                        </div>

                        <Button
                            type="submit"
                            class="mt-4 w-full flex"
                            :tabindex="6"
                            data-test="season-button"
                        >
                            <Spinner v-if="processing" />
                            {{ buttonAction }} Announcement
                        </Button>
                    </div>

                </div>
            </Form>
        </div>
    </AppLayout>
</template>

<script lang="ts">
import axios from "axios";
import { Quill } from '@vueup/vue-quill';

export default {
    data() {
        return {
            announcement: '',
            buttonAction: 'Create',
            isUpdate: false,
            announcementId: '0',
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

            this.announcementId = queryString.substring(queryString.indexOf("announcement_id=") + 16);

            if (parseInt(this.announcementId) > 0) {
                try {
                    const response = await axios.get("/single-announcement", {
                        params: { announcement_id: this.announcementId }
                    });

                    this.isUpdate = true;
                    this.announcement = response.data[0].announcement;

                    this.buttonAction = "Update";
                } catch (error) {
                    console.error("Error fetching season:", error);
                }
            }
        },
        handleSubmit() {
            const quill = new Quill('#announcement-editor');
            this.announcement = quill.root.innerHTML;
        },
    },
    mounted() {
        this.getQueryParams();
    }
}

</script>