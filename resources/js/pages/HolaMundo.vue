<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="HolaMundo" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex items-center justify-center">
        <p class="text-amber-600 text-9xl">¡Hola Mundo!</p>
    </div>
    </AppLayout>
</template>
