<script setup lang="ts">
import { ref } from 'vue'; // 👈 agregado

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
const count = ref(0);
const increment = () => count.value++;
const decrement = () => count.value--;
</script>

<template>
    <Head title="Contador" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col items-center justify-center gap-6">
            <p class="text-amber-600 text-9xl">Contador</p>
            <p class="text-6xl font-bold">{{ count }}</p>
            <div class="flex gap-4">
                <button
                    @click="decrement"
                    class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600"
                >
                    -1
                </button>
                <button
                    @click="increment"
                    class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600"
                >
                    +1
                </button>
            </div>
        </div>
    </AppLayout>
</template>
