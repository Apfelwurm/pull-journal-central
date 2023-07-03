<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UserTable from '@/Components/UserTable.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users : Object,
})

</script>

<template>
    <Head title="Usermanagement" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                        <UserTable :users="users"></UserTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
