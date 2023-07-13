<template>
    <AppLayout title="Edit organisation">

        <template #header>
            <Breadcrumb :href="'organisations'" :title="'Organisations'" :property="organisation" />
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="w-full max-w-xs m-auto">
                    <form @submit.prevent="submit" class="px-8 pt-6 pb-8 mb-4 bg-white rounded shadow-md">

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                                Organisation name
                            </label>
                            <input v-model="form.name"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="name" type="text">
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
    organisation: {
        type: Object,
    },
});

const form = useForm({
    name: props.organisation.name,
});

const submit = () => {
    form.put(route('organisations.update', props.organisation.id));
};

</script>
