<?php

namespace App\Observers;

use App\Events\SmsSendingEvent;
use App\Models\Patient;
use App\Services\SmsToggle;
use Exception;
use Illuminate\Support\Facades\Log;

class PatientObserver
{
    public function created(Patient $patient): void
    {
        if (!SmsToggle::shouldSendPatientSms()) {
            Log::info("Patient SMS disabled by user", ['patient_id' => $patient->id]);
            return;
        }

        try {
            $phone = $patient->mobile ?: $patient->phone;

            if (!$phone) {
                Log::info("Patient has no phone number, skipping SMS", [
                    'patient_id' => $patient->id
                ]);
                return;
            }

            $clinicName = $this->getSetting('clinic_name', 'Our Clinic');
            $clinicPhone = $this->getSetting('clinic_phone', '');

            event(new SmsSendingEvent(
                $this->formatPhone($phone),
                'patient_registration',
                [
                    'patient_name' => $patient->name,
                    'patient_id' => $patient->patientId ?? $patient->id,
                    'clinic_name' => $clinicName,
                    'clinic_phone' => $clinicPhone
                ],
                $patient
            ));
        } catch (Exception $e) {
            Log::error("Patient SMS observer failed", [
                'patient_id' => $patient->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function updated(Patient $patient): void
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