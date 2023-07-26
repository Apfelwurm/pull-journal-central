<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NotificationSettingController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'enable_notifications' => ['required', 'boolean'],
            'enable_provider_mail' => ['required', 'boolean'],
            'enable_provider_ntfy' => ['required', 'boolean'],
            'enable_log_entry_created_notification' => ['required', 'boolean'],
            'enable_device_created_notification' => ['required', 'boolean'],
            'ntfy_channel_id' => ['required_unless:enable_provider_ntfy,false', 'string', 'nullable'],
        ]);

        $request->user()->notificationSetting()->update([
            'enable_notifications' => $validated['enable_notifications'],
            'enable_provider_mail' => $validated['enable_provider_mail'],
            'enable_provider_ntfy' => $validated['enable_provider_ntfy'],
            'enable_log_entry_created_notification' => $validated['enable_log_entry_created_notification'],
            'enable_device_created_notification' => $validated['enable_device_created_notification'],
            'ntfy_channel_id' => $validated['ntfy_channel_id'],
        ]);

        return back();
    }

}
