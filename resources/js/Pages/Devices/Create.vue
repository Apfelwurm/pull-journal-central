<template>
    <AppLayout title="Create device">

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                <Link :href="route('devices.index')">Devices</Link> / Register device
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="w-full max-w-s m-auto">

                    <div v-if="!$page.props.auth.isSuperAdmin"
                        class="px-8 pt-6 pb-8 m-auto mb-4 bg-white rounded shadow-md">
                        To register a new Device for your Organisation "{{ organisation.name }}" use the following data:
                        <br>
                        <br>
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

                    <div v-if="$page.props.auth.isSuperAdmin" class="px-8 pt-6 pb-8 m-auto mb-4 bg-white rounded shadow-md">

                        To register a new Device use the following data:
                        <br>
                        <br>
                        Base URL:
                        <div class="text-sm text-center text-gray-900">
                            <span
                                class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                {{ url }}
                            </span>
                        </div>

                        <div class="mt-8 text-semi-bold text-xl text-gray-900">

                            Available Organisations:
                        </div>

                        <div class="mt-8 text-gray-900">

                            <table class="table-fixed">
                                <caption style="display: none;">organisation listing</caption>

                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Organisation ID</th>
                                        <th>Registration Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="organisationlisted in organisations">
                                        <td>{{ organisationlisted.name }}</td>
                                        <td>{{ organisationlisted.id }}</td>
                                        <td>{{ organisationlisted.registrationpassword }}</td>
                                    </tr>
                                </tbody>
                            </table>

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
    organisations: {
        type: Object,
    },
    url: {
        type: String,
    }
});

</script>
