<template>
    <AppLayout title="User profile">
        <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
            <div class="w-full max-w-lg overflow-hidden bg-white rounded-lg shadow-lg">
                <div class="p-4">

                    <h1 class="text-2xl font-bold text-center">{{ getUser.name }}</h1>
                    <div class="text-center">
                        <a :href="'mailto:' + getUser.email" class="text-center text-gray-600">{{ getUser.email }}</a>
                    </div>
                    <hr class="my-4">
                    <div class="my-2">
                        <h2 class="text-sm font-bold text-gray-600 uppercase">About</h2>
                        <p class="mt-2 text-gray-600">Role: {{ getUser.role.name }}</p>
                        <p class="mt-2 text-gray-600">Organisataion: {{ getUser.organisation.name }}</p>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    getUser: {
        type: Object,
    },
});
</script>
