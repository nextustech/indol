<?php

namespace App\Observers;

use App\Events\SmsSendingEvent;
use App\Models\Collection;
use App\Services\SmsToggle;
use Exception;
use Illuminate\Support\Facades\Log;

class CollectionObserver
{
    public function created(Collection $collection): void
    {
        if (!SmsToggle::shouldSendCollectionSms()) {
            Log::info("Collection SMS disabled by user", ['collection_id' => $collection->id]);
            return;
        }

        try {
            $patient = $collection->patient;

            if (!$patient) {
                Log::info("Collection has no patient, skipping SMS", [
                    'collection_id' => $collection->id
                ]);
                return;
            }

            $phone = $patient->mobile ?: $patient->phone;

            if (!$phone) {
                Log::info("Patient has no phone number, skipping SMS", [
                    'patient_id' => $patient->id
                ]);
                return;
            }

            $clinicName = $this->getSetting('clinic_name', 'Our Clinic');

            event(new SmsSendingEvent(
                $this->formatPhone($phone),
                'deposit_received',
                [
                    'patient_name' => $patient->name,
                    'amount' => number_format($collection->amount, 0),
                    'balance' => number_format($collection->amount, 0),
                    'clinic_name' => $clinicName
                ],
                $collection
            ));
        } catch (Exception $e) {
            Log::error("Collection SMS observer failed", [
                'collection_id' => $collection->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function updated(Collection $collection): void
    {
    }

    private function getSetting(string $key, $default = null)
    {
        $option = \App\Models\Option::where('option_key', $key)->first();
        return $option ? $option->option_value : $default;
    }

    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) == 10) {
            return '+91' . $phone;
        }

        if (strlen($phone) == 11 && $phone[0] == '0') {
            return '+91' . substr($phone, 1);
        }

        if (!str_starts_with($phone, '+')) {
            return '+' . $phone;
        }

        return $phone;
    }
}