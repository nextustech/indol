<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsToggle
{
    private static ?Request $request = null;
    private static ?int $branchId = null;

    public static function setRequest(Request $request): void
    {
        self::$request = $request;
    }

    public static function setBranchId(int $branchId): void
    {
        self::$branchId = $branchId;
    }

    public static function getBranchId(): ?int
    {
        return self::$branchId;
    }

    public static function shouldSendPatientSms(): bool
    {
        if (!self::$request) {
            return true;
        }

        if (self::$request->has('send_sms_patient')) {
            $value = self::$request->input('send_sms_patient');
            $result = in_array($value, ['1', 'true', true], true);
            return $result;
        }

        return true;
    }

    public static function shouldSendCollectionSms(): bool
    {
        if (!self::$request) {
            return true;
        }

        if (self::$request->has('send_sms_collection')) {
            $value = self::$request->input('send_sms_collection');
            $result = in_array($value, ['1', 'true', true], true);
            return $result;
        }

        return true;
    }
}