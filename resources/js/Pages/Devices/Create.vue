<template>
    <AppLayout title="Create device">

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                <Link :href="route('devices.index')">Devices</Link> / Register device
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="w-full max-w-xs m-auto">

                    <div  class="px-8 pt-6 pb-8 m-auto mb-4 bg-white rounded shadow-md">
                    To register a new Device for your Organisation "{{ organisation.name }}" use the following data:
                    
                    Base URL:
                    <div class="text-sm text-center text-gray-900">
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                            {{ url }}
                        </span>
                    </div>

                   Organisation id:
                    <div class="text-sm text-center text-gray-900">
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                            {{ organisation.id }}
                        </span>
                    </div>
                    
                    Registration Password:
                    <div class="text-sm text-center text-gray-900">
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                            {{ organisation.registrationpassword }}
                        </span>
                    </div>

                </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3'


const props = defineProps({
    organisation: {
        type: Object,
    },
    url: {
        type: String,
    }
});

</script>
