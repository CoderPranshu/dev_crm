<?php

use App\Models\NotificationSetting;
use App\Models\User;

if (!function_exists('getNotificationRecipients')) {
    function getNotificationRecipients(string $type, string $channel = 'system', array $extraUsers = [])
    {
        $column = match ($channel) {
            'mail' => 'mail_enabled',
            'sms'  => 'sms_enabled',
            default => 'system_enabled',
        };

        $settings = NotificationSetting::with(['user', 'role'])
            ->where('notification_type', $type)
            ->where('is_active', true)
            ->where($column, true)
            ->get();

        $users = collect();

        foreach ($settings as $setting) {
            if ($setting->user) {
                $users->push($setting->user);
            }

            if ($setting->role) {
                $roleUsers = User::role($setting->role->name)->get();
                $users = $users->merge($roleUsers);
            }
        }

        if (!empty($extraUsers)) {
            $users = $users->merge(collect($extraUsers));
        }

        return $users->filter()->unique('id')->values();
    }
}
