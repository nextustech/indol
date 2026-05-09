<?php

namespace App\Traits;

trait SmsControl
{
    protected function shouldSendSms($request, string $type = 'default'): bool
    {
        $key = "send_sms_{$type}";

        if ($request->has($key)) {
            return filter_var($request->input($key), FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('send_sms')) {
            return filter_var($request->input('send_sms'), FILTER_VALIDATE_BOOLEAN);
        }

        return true;
    }
}