<template>
    <AppLayout title="User profile">
        <div class=" flex flex-col items-center justify-center min-h-screen bg-gray-100">
            <div class="w-full overflow-hidden bg-white rounded-lg shadow-lg" style="max-width: 80rem;">
                <div class="bg-white">
                    <div
                        class="mx-auto grid max-w-2xl grid-cols-1 items-center gap-x-8 gap-y-16 px-4 py-24 sm:px-6 sm:py-32 lg:max-w-7xl lg:grid-cols-2 lg:px-8">
                        <div class="mt-8">
                            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Log Details</h2>
                            <dl class="mt-8 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 sm:gap-y-16 lg:gap-x-8">
                                <div class="border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">ID</dt>
                                    <dd class="mt-2 text-sm text-gray-500">{{ logEntry.data.id }}</dd>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">Device</dt>
                                    <dd class="mt-2 text-sm text-gray-500">ID: {{ logEntry.data.device.id }}</dd>
                                    <dd class="mt-2 text-sm text-gray-500">Name: {{ logEntry.data.device.name }}</dd>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">Source</dt>
                                    <dd class="mt-2 text-sm text-gray-500">{{ logEntry.data.source }}</dd>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">Class</dt>
                                    <dd class="mt-2 text-sm text-gray-500">
                                        <span v-if="logEntry.data.class === 'success'"
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            {{ logEntry.data.class }}
                                        </span>
                                        <span v-else-if="logEntry.data.class === 'info'"
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full">
                                            {{ logEntry.data.class }}
                                        </span>
                                        <span v-else-if="logEntry.data.class === 'error'"
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            {{ logEntry.data.class }}
                                        </span>
                                        <span v-else-if="logEntry.data.class === 'warning'"
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">
                                            {{ logEntry.data.class }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">Acknowledged</dt>
                                    <dd class="mt-2 text-sm text-gray-500">
                                        <div class="grid grid-cols-2">



                                            <span v-if="logEntry.data.formatted_acknowledged_at === 'not acknowledged'"
                                                class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-red-100 rounded-full">
                                                {{ logEntry.data.formatted_acknowledged_at }}
                                            </span>
                                            <div v-else>
                                                <span
                                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                    <div>{{ logEntry.data.formatted_acknowledged_at }}</div>
                                                </span>
                                                <div>by: <inertia-link class="transition hover:text-blue-500"
                                                        :href="`users/${logEntry.data.acknowledgedfrom.id}`">{{
                                                            logEntry.data.acknowledgedfrom.name }}</inertia-link></div>

                                            </div>

                                            <div v-if="$page.props.auth.isDeviceAdmin || $page.props.auth.isSuperAdmin"
                                                class="">

                                                <div v-if="logEntry.data.formatted_acknowledged_at === 'not acknowledged'">
                                                    <a title="Aknowledge entry" @click="aknowledgeLogEntry()"
                                                        class="float-left ml-2 text-green-400 duration-100 rounded hover:text-green-600">
                                                        Aknowledge entry
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="green"
                                                            stroke="currentColor" viewBox="0 0 448 512">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div v-else>
                                                    <a title="Unaknowledge entry" @click="unaknowledgeLogEntry()"
                                                        class="float-left ml-2 text-red-400 duration-100 rounded hover:text-red-600">
                                                        Unaknowledge entry
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="red"
                                                            stroke="currentColor" viewBox="0 0 448 512">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                                        </svg>
                                                    </a>
                                                </div>

                                            </div>

                                        </div>

                                    </dd>

                                </div>
                                <div class="border-t border-b border-gray-200 pt-4">
                                    <dt class="font-medium text-gray-900">Created at</dt>
                                    <dd class="mt-2 text-sm text-gray-500">{{ logEntry.data.formatted_created_at }}</dd>
                                </div>
                            </dl>
                        </div>

                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl mt-16 ">Log Content</h2>

                        <div class="mt-8">
                            {{ logEntry.data.content }}
                        </div>
                        <div class="mt-8"></div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    logEntry: {
        type: Object,
    },
});


const aknowledgeLogEntry = () => {
    if (!confirm('Are you sure want to aknowledge the entry?')) return;
    router.get(route('logEntries.aknowledge', props.logEntry.data.id), {
        _token: props.csrf_token
    });
};

const unaknowledgeLogEntry = () => {
    if (!confirm('Are you sure want to unaknowledge the entry?')) return;
    router.get(route('logEntries.unaknowledge', props.logEntry.data.id), {
        _token: props.csrf_token
    });
};

</script>
