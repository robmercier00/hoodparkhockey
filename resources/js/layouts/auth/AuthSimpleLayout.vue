<script setup lang="ts">
defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex flex-col gap-8">
        <div class="flex flex-col items-center gap-4">
            <div class="space-y-2 text-center">
                <h1 class="text-xl font-medium">{{ title }}</h1>
                <p class="text-center text-sm text-muted-foreground">
                    {{ description }}
                </p>
            </div>
        </div>
        <slot />
    </div>
</template>
