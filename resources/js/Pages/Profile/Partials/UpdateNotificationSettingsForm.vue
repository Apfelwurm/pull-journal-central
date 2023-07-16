<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const EnableNotificationsInput = ref(null);
const EnableProvicerMailInput = ref(null);
const EnableProvicerNtfyInput = ref(null);
const EnableLogEntryCreatedNotificationInput = ref(null);
const ntfyChannelIdInput = ref(null);

const notificationSettings = usePage().props.auth.user.notification_setting;

const form = useForm({
    enable_notifications: notificationSettings.enable_notifications,
    enable_provider_mail: notificationSettings.enable_provider_mail,
    enable_provider_ntfy: notificationSettings.enable_provider_ntfy,
    enable_log_entry_created_notification: notificationSettings.enable_log_entry_created_notification,
    ntfy_channel_id : notificationSettings.ntfy_channel_id,
});



const updateNotificationSettings = () => {
    form.put(route('notificationSetting.update'), {
        preserveScroll: true,
        onError: () => {
            if (form.errors.enable_notifications) {
                form.reset('enable_notifications');
                EnableNotificationsInput.value.focus();
            }
            if (form.errors.enable_provider_mail) {
                form.reset('enable_provider_mail');
                EnableProvicerMailInput.value.focus();
            }
            if (form.errors.enable_provider_ntfy) {
                form.reset('enable_provider_ntfy');
                EnableProvicerNtfyInput.value.focus();
            }
            if (form.errors.enable_log_entry_created_notification) {
                form.reset('enable_log_entry_created_notification');
                EnableLogEntryCreatedNotificationInput.value.focus();
            }
            if (form.errors.ntfy_channel_id) {
                form.reset('ntfy_channel_id');
                ntfyChannelIdInput.value.focus();
            }
        },
    });
};

const generateNtfyChannelId = () => {
    form.ntfy_channel_id = Math.random().toString(36).slice(2);
};
    

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Notifications</h2>
        </header>

        <form @submit.prevent="updateNotificationSettings" class="mt-6 space-y-6">
            <div>
            <h3 class="text-md font-medium text-gray-900">Global settings</h3>

                <InputLabel for="enable_notifications" value="Enable Notifications" />

                <Checkbox
                    id="enable_notifications"
                    v-model:checked="form.enable_notifications"
                    ref="EnableNotificationsInput"
                    class="mt-1"
                />

                <InputError :message="form.errors.enable_notifications" class="mt-2" />
            </div>
            <div>
                <h3 class="text-md font-medium text-gray-900">Notification Providers</h3>
                <div>
                <InputLabel for="enable_provider_mail" value="Enable Email" />

                <Checkbox
                    id="enable_provider_mail"
                    v-model:checked="form.enable_provider_mail"
                    ref="EnableProvicerMailInput"
                    class="mt-1"
                />

                <InputError :message="form.errors.enable_provider_mail" class="mt-2" />
                </div>
                    

                <div class="container m-auto grid grid-cols-2 gap-6">
                    <div class="">
                        <InputLabel for="enable_provider_ntfy" value="Enable Ntfy" />

                        <Checkbox
                            id="enable_provider_ntfy"
                            v-model:checked="form.enable_provider_ntfy"
                            ref="EnableProvicerNtfyInput"
                            class="mt-1"
                        />

                        <InputError :message="form.errors.enable_provider_ntfy" class="mt-2" />
                        
                    </div>
                    <div class="">
                        <InputLabel for="ntfy_channel_id" value="Ntfy Channel ID" />

                        <TextInput
                            id="ntfy_channel_id"
                            ref="ntfyChannelIdInput"
                            v-model="form.ntfy_channel_id"
                            type="text"
                            class="mt-1"
                        />
                        <PrimaryButton @click="generateNtfyChannelId()" type="button" title="generate Ntfy Channel Id (you have to save afterwards!)">generate </PrimaryButton>
                        <InputError :message="form.errors.ntfy_channel_id" class="mt-2" />
                        
                    </div>
                    
                </div>


                    
            
            

            </div>

            <div>
                <h3 class="text-md font-medium text-gray-900">Notifications</h3>
                <div>
                <InputLabel for="enable_log_entry_created_notification" value="Log Entry creation" />

                <Checkbox
                    id="enable_log_entry_created_notification"
                    v-model:checked="form.enable_log_entry_created_notification"
                    ref="EnableLogEntryCreatedNotificationInput"
                    class="mt-1"
                />

               

                <InputError :message="form.errors.enable_log_entry_created_notification" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
