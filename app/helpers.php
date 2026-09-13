<?php

use App\Notifications\SystemNotification;
use App\Models\User;

if (!function_exists('sendSystemNotification')) {
    function sendSystemNotification(
        $users,
        string $title,
        string $message,
        string $type = 'general',
        ?string $url = null,
        array $extra = [],
        ?string $sound = 'notification.mp3'
    ) {
        foreach ($users as $user) {
            if (!$user) {
                continue;
            }

            $user->notify(new SystemNotification(
                $title,
                $message,
                $type,
                $url,
                $extra,
                $sound
            ));
        }
    }
}
