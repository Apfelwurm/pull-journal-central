<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    BUILDNUMBER: String,
    BUILDID: String,
    SOURCE_COMMIT: String,
    BUILDNODE: String,
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Welcome to your pull-journal-central.</div>

                    <div class="p-6 font-semibold text-gray-900">Versions</div>
                    <div class="mx-auto max-w-7xl px-6 lg:px-8 mb-8">
                        <dl class="grid grid-cols-1 gap-x-2 gap-y-16 text-center lg:grid-cols-1">
                            <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                                <dt class="text-base leading-7 text-gray-600">BUILDNUMBER</dt>
                                <dd class="order-first font-semibold tracking-tight text-gray-900">{{ BUILDNUMBER }}</dd>
                            </div>
                            <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                                <dt class="text-base leading-7 text-gray-600">BUILDID</dt>
                                <dd class="order-first font-semibold tracking-tight text-gray-900 ">{{ BUILDID }}</dd>
                            </div>
                            <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                                <dt class="text-base leading-7 text-gray-600">SOURCE_COMMIT</dt>
                                <dd class="order-first font-semibold tracking-tight text-gray-900 ">{{ SOURCE_COMMIT }}</dd>
                            </div>
                            <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                                <dt class="text-base leading-7 text-gray-600">BUILDNODE</dt>
                                <dd class="order-first font-semibold tracking-tight text-gray-900 ">{{ BUILDNODE }}</dd>
                            </div>
                        </dl>
                    </div>


                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

