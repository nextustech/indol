<?php

return [
    'default_device' => env('SMS_DEVICE', 0),

    'rate_limit' => env('SMS_RATE_LIMIT', 100),

    'duplicate_window' => env('SMS_DUPLICATE_WINDOW', 5),

    'max_attempts' => env('SMS_MAX_ATTEMPTS', 3),

    'timeout' => env('SMS_TIMEOUT', 30),
];