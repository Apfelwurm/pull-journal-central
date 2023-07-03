<script setup>


const props = defineProps({
    users : Object,
})


</script>

<template>
    <div class="text-gray-900 bg-gray-200">
        <div class="px-3 py-4 flex justify-center">
            <table class="w-full text-md bg-white shadow-md rounded mb-4">
                <tbody>
                    <tr class="border-b">
                        <th class="text-left p-3 px-5">Name</th>
                        <th class="text-left p-3 px-5">Email</th>
                        <th class="text-left p-3 px-5">Viewer</th>
                        <th class="text-left p-3 px-5">Admin</th>
                        <th></th>
                    </tr>
                    <tr v-for="user in users" class="border-b hover:bg-orange-100 bg-gray-100">
                        <td class="p-3 px-5"><input type="text" v-model="user.name" class="bg-transparent"></td>
                        <td class="p-3 px-5"><input type="text" v-model="user.email" class="bg-transparent"></td>
                        <td class="p-3 px-5">
                            <input type="checkbox" id="checkbox" v-model="user.isAllowedToView" :true-value="1" :false-value="0"/>
                        </td>
                        <td class="p-3 px-5">
                            <input type="checkbox" id="checkbox" v-model="user.isAdmin" :true-value="1" :false-value="0"/>
                        </td>
                        <td class="p-3 px-5 flex justify-end"><button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button><button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
