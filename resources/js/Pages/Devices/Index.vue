<template>
    <AppLayout title="Devices">

        <template #header>
            <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800">
                <p>
                    Devices
                    <i class="fa-solid fa-user-gear"></i>
                </p>
                <inertia-link href="devices/create">
                    <a
                        class="px-4 py-2 mr-3 text-sm text-green-600 transition border border-green-300 rounded-full hover:bg-green-600 hover:text-white hover:border-transparent">Create
                        device</a>
                </inertia-link>

            </h2>
        </template>
        <div class="py-12">

            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex justify-end mt-3">
                        <div class="mb-3 xl:w-96">
                            <div class="relative flex items-stretch w-4/5 mb-3 input-group">

                                <input id="search" type='text' v-model="term"
                                    class="outline-none focus:ring-0 rounded-r-none form-control relative min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0"
                                    placeholder="Search...">

                                <button
                                    class="rounded-l-none btn px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700  focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex items-center"
                                    type="button" id="button-addon2">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search"
                                        class="w-4" device="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                            d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <caption style="display: none;">Devices listing</caption>
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Device Identifier
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Created at
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Log count
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Organisation
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Last Connection
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Verification
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="device in devices.data" :key="device.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ device.id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        <inertia-link class="transition hover:text-blue-500" :href="`devices/${device.id}`">{{
                                            device.name }}</inertia-link>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        <inertia-link class="transition hover:text-blue-500" :href="`devices/${device.id}`">{{
                                            device.deviceidentifier }}</inertia-link>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            {{ device.formatted_created_at }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 text-xs font-semibold leading-5 text-purple-800 bg-purple-200 rounded-full">
                                        {{ device.logcount }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <inertia-link class="transition hover:text-blue-500" :href="`organisations/${device.organisation.id}`">{{
                                            device.organisation.name }}</inertia-link>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        <span v-if="device.formatted_last_api_call  === 'never'"
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-red-100 rounded-full">
                                            {{ device.formatted_last_api_call }}
                                        </span>
                                        <span v-else
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            {{ device.formatted_last_api_call }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        <span v-if="device.formatted_verified_at  === 'not verified'"
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-red-100 rounded-full">
                                            {{ device.formatted_verified_at }}
                                        </span>
                                        <div v-else>
                                        <span 
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            <div>{{ device.formatted_verified_at }}</div>
                                        </span>
                                            <div>by: <inertia-link class="transition hover:text-blue-500" :href="`users/${device.verifiedfrom.id}`">{{
                                            device.verifiedfrom.name }}</inertia-link></div>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">

                                    <inertia-link title="Edit Device" :href="`/devices/${device.id}/edit`"
                                        class="float-left px-4 py-2 text-green-400 duration-100 rounded hover:text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg></inertia-link>

                                    <a href="#" title="Delete Device" @click="deleteDevice(device)"
                                        class="float-left px-4 py-2 ml-2 text-red-400 duration-100 rounded hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                    <div v-if="device.formatted_last_api_call  === 'never'">
                                    <a title="Verify Device" href="#" @click="verifyDevice(device)"
                                        class="float-left px-4 py-2 ml-2 text-green-400 duration-100 rounded hover:text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="green" stroke="currentColor" viewBox="0 0 448 512"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                    </a>
                                    </div>
                                    <div v-else>
                                    <a title="Unverify Device" href="#" @click="unverifyDevice(device)"
                                        class="float-left px-4 py-2 ml-2 text-red-400 duration-100 rounded hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="red" stroke="currentColor" viewBox="0 0 448 512"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                                    </a>
                                    </div>


                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination class="mt-6" :links="devices.meta.links" :term="term" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script setup>
import { reactive, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import debounce from 'lodash.debounce'

const props = defineProps({
  devices: Object,
});

const term = ref('')
const state = reactive({
  term: term || ''
});

watch(term, debounce(() => {
	router.get(route('devices.index'), {term: state.term}, {preserveState: true, preserveScroll: true, only: ['devices']})
}, 300));




const deleteDevice = (device) => {
  if (!confirm('Are you sure want to delete device?')) return;
  router.delete(route('devices.destroy', device.id), {
    _token: props.csrf_token
  });
};


const verifyDevice = (device) => {
  if (!confirm('Are you sure want to verify the device?')) return;
  router.get(route('devices.verify', device.id), {
    _token: props.csrf_token
  });
};

const unverifyDevice = (device) => {
  if (!confirm('Are you sure want to unverify the device?')) return;
  router.get(route('devices.unverify', device.id), {
    _token: props.csrf_token
  });
};


</script>



