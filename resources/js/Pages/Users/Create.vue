<template>
    <AppLayout title="Create user">

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create user
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="w-full max-w-xs m-auto">

                    <form @submit.prevent="submit" class="px-8 pt-6 pb-8 m-auto mb-4 bg-white rounded shadow-md"
                        enctype="multipart/form-data">

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.name"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="name" type="text">
                            <span class="text-red-500">{{ errors.name }}</span>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                                E-mail <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.email"
                                class="w-full px-3 py-2 mb-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="email" type="email">
                            <span class="text-red-500">{{ errors.email }}</span>
                        </div>

                        <div class="mb-4">
                            <div class="mb-3 xl:w-96">
                                <select v-model="form.role_id"
                                    class="block m-0 text-base font-normal text-gray-700 ease-in-out bg-white bg-no-repeat border border-gray-300 border-solid rounded appearance-none form-select bg-clip-padding focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    aria-label="Default select example">
                                    
                                    <option v-for="role in roles" :value="role.id">{{ role.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input v-model="form.password"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded appearance-none mb- 2shadow focus:outline-none focus:shadow-outline"
                                id="password" type="password">
                            <span class="text-red-500">{{ errors.password }}</span>
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

<script>
import Button from '@/Components/Button.vue';
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
    components: {
        AppLayout,
        Button,
    },
    props: {
        errors: Object,
        roles: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                role_id: 2,
                password: '',
                avatar: null,
                description: ''
            })
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('users.store'), {
                _token: this.$page.props.csrf_token,
            });
        }
    }
}
</script>