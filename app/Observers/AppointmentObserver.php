<?php

namespace App\Observers;

use App\Events\SmsSendingEvent;
use App\Models\Appointment;
use Exception;
use Illuminate\Support\Facades\Log;

class AppointmentObserver
{
    public function created(Appointment $appointment): void
    {
        try {
            $phone = $appointment->phone;

            if (!$phone) {
                Log::info("Appointment has no phone, skipping SMS", [
                    'appointment_id' => $appointment->id
                ]);
                return;
            }

            $clinicName = $this->getSetting('clinic_name', 'Our Clinic');
            $doctorName = $appointment->appointmentType?->name ?? 'Doctor';

            event(new SmsSendingEvent(
                $this->formatPhone($phone),
                'appointment_booked',
                [
                    'patient_name' => $appointment->patient_name,
                    'appointment_date' => $appointment->appointment_date,
                    'appointment_time' => $appointment->start_time,
                    'doctor_name' => $doctorName,
                    'clinic_name' => $clinicName
                ],
                $appointment
            ));
        } catch (Exception $e) {
            Log::error("Appointment SMS observer failed", [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function updated(Appointment $appointment): void
    {
        if ($appointment->isDirty(['appointment_date', 'start_time', 'end_time'])) {
            try {
                $phone = $appointment->phone;

                if (!$phone) {
                    return;
                }

                $clinicName = $this->getSetting('clinic_name', 'Our Clinic');
                $original = $appointment->getOriginal();

                event(new SmsSendingEvent(
                    $this->formatPhone($phone),
                    'schedule_update',
                    [
                        'patient_name' => $appointment->patient_name,
                        'old_date' => $original['appointment_date'],
                        'old_time' => $original['start_time'],
                        'new_date' => $appointment->appointment_date,
                        'new_time' => $appointment->start_time,
                        'clinic_name' => $clinicName
                    ],
                    $appointment
                ));
            } catch (Exception $e) {
                Log::error("Appointment update SMS observer failed", [
                    'appointment_id' => $appointment->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
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