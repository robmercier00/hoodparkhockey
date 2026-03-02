<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import Navigation from '@/components/Navigation.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes/login';
import { request } from '@/routes/password';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
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
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                >
                    <AuthBase
                        title="HPHL Admin Login"
                        description="Enter your email and password below to log in"
                    >
                        <Head title="Log in" />

                        <div
                            v-if="status"
                            class="mb-4 text-center text-sm font-medium text-green-600"
                        >
                            {{ status }}
                        </div>

                        <Form
                            v-bind="login.form()"
                            :reset-on-success="['password']"
                            v-slot="{ errors, processing }"
                            class="flex flex-col gap-6"
                        >
                            <div class="grid gap-6">
                                <div class="grid gap-2">
                                    <Label for="email">Email address</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        name="email"
                                        required
                                        autofocus
                                        :tabindex="1"
                                        autocomplete="email"
                                        placeholder="email@example.com"
                                    />
                                    <InputError :message="errors.email" />
                                </div>

                                <div class="grid gap-2">
                                    <div class="flex items-center justify-between">
                                        <Label for="password">Password</Label>
                                        <TextLink
                                            v-if="canResetPassword"
                                            :href="request()"
                                            class="text-sm"
                                            :tabindex="5"
                                        >
                                            Forgot password?
                                        </TextLink>
                                    </div>
                                    <Input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        :tabindex="2"
                                        autocomplete="current-password"
                                        placeholder="Password"
                                    />
                                    <InputError :message="errors.password" />
                                </div>

                                <div class="flex items-center justify-between">
                                    <Label for="remember" class="flex items-center space-x-3">
                                        <Checkbox id="remember" name="remember" :tabindex="3" />
                                        <span>Remember me</span>
                                    </Label>
                                </div>

                                <Button
                                    type="submit"
                                    class="mt-4 w-full"
                                    :tabindex="4"
                                    :disabled="processing"
                                    data-test="login-button"
                                >
                                    <Spinner v-if="processing" />
                                    Log in
                                </Button>
                            </div>
                        </Form>
                    </AuthBase>
                </div>
            </main>
        </div>
    </div>
</template>
