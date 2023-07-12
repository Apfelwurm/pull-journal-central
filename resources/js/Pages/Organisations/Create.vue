<template>
    <AppLayout title="Create organisation">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                <Link :href="route('organisations.index')">Organisations</Link> / Create organisation
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="w-full max-w-xs m-auto">
                    <form @submit.prevent="submit" class="px-8 pt-6 pb-8 m-auto mb-4 bg-white rounded shadow-md"
                        enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                                Organisation name <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.name"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="name" type="text" />
                            <span class="text-red-500">{{ errors.name }}</span>
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
import Button from '@/Components/Button.vue';
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Link } from '@inertiajs/vue3'


const props = defineProps({
    errors: {
        type: Object,
    },
});

const form = useForm({
    name: '',
});

const submit = () => {
    form.post(route('organisations.store'));
};

</script>
