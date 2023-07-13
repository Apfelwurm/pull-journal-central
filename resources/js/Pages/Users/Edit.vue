<template>
    <AppLayout title="Edit user">

        <template #header>
            <Breadcrumb :href="'users'" :title="'Users'" :property="user" />
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="w-full max-w-xs m-auto">
                    <form @submit.prevent="submit" class="px-8 pt-6 pb-8 mb-4 bg-white rounded shadow-md">

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                                Name
                            </label>
                            <input v-model="form.name"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="name" type="text">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                                E-mail
                            </label>
                            <input v-model="form.email"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="email" type="email">
                        </div>

                        <div class="mb-4">
                            <div class="mb-3 xl:w-96">


                                <select v-model="form.role" required :dataSet="roles"
                                    class="block m-0 text-base font-normal text-gray-700 ease-in-out bg-white bg-no-repeat border border-gray-300 border-solid rounded appearance-none form-select bg-clip-padding focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    aria-label="Default select example">

                                    <option v-for="role in roles">{{ role }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="mb-3 xl:w-96">
                                <select v-model="form.organisation_id"
                                    class="block m-0 text-base font-normal text-gray-700 ease-in-out bg-white bg-no-repeat border border-gray-300 border-solid rounded appearance-none form-select bg-clip-padding focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    aria-label="Default select example">

                                    <option v-for="organisation in organisations" :value="organisation.id">{{ organisation.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <Button :form="form"></Button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>

import Breadcrumb from "@/Components/Breadcrumb.vue";
import Button from "@/Components/Button.vue";
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    user: {
        type: Object,
    },
    roles: {
        type: Object,
    },
    organisations: {
        type: Object,
    },
});

const form = useForm({
    name: props.user.name,
    role: props.user.role,
    organisation_id: props.user.organisation.id,
    email: props.user.email,
});

const submit = () => {
    form.put(route('users.update', props.user.id));
};

</script>
