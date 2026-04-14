<?php

namespace App\Services;

use App\Models\AvailabilityWindow;
use App\Models\Appointment;
use App\Models\Holiday;
use Carbon\Carbon;

class SlotService
{
    public function getSlots($branch_id, $appointment_type_id, $date)
    {
        $dateObj = Carbon::parse($date);
        $dayOfWeek = $dateObj->dayOfWeek;

        // 🔴 1. Check Full-Day Holiday
        $isHoliday = Holiday::where('branch_id', $branch_id)
            ->whereDate('start_date', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereDate('end_date', '>=', $date)
                  ->orWhereNull('end_date');
            })
            ->where('is_full_day', true)
            ->exists();

        if ($isHoliday) {
            return [];
        }

        // 🟡 2. Get Partial Holidays
        $partialHolidays = Holiday::where('branch_id', $branch_id)
            ->whereDate('start_date', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereDate('end_date', '>=', $date)
                  ->orWhereNull('end_date');
            })
            ->where('is_full_day', false)
            ->get();

        // 🟢 3. Get Availability Windows
        $windows = AvailabilityWindow::where('branch_id', $branch_id)
            ->where('appointment_type_id', $appointment_type_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->get();

        $slots = [];

        foreach ($windows as $window) {

            $start = Carbon::parse($window->start_time);
            $end = Carbon::parse($window->end_time);

            while ($start < $end) {

                $slotStart = $start->copy();
                $slotEnd = $start->copy()->addMinutes($window->slot_duration);

                if ($slotEnd > $end) {
                    break;
                }

                // 🔴 Skip Past Time (for today)
                if ($dateObj->isToday() && $slotStart < now()) {
                    $start->addMinutes($window->slot_duration);
                    continue;
                }

                // 🟡 Skip Partial Holidays
                $skip = false;
                foreach ($partialHolidays as $holiday) {
                    if (
                        $holiday->start_time &&
                        $holiday->end_time &&
                        $slotStart->format('H:i:s') < $holiday->end_time &&
                        $slotEnd->format('H:i:s') > $holiday->start_time
                    ) {
                        $skip = true;
                        break;
                    }
                }

                if ($skip) {
                    $start->addMinutes($window->slot_duration);
                    continue;
                }

                // 🔵 Count Bookings
                $booked = Appointment::where('branch_id', $branch_id)
                    ->where('appointment_type_id', $appointment_type_id)
                    ->where('appointment_date', $date)
                    ->where('start_time', $slotStart->format('H:i:s'))
                    ->count();

                $available = $window->capacity - $booked;

                $slots[] = [
                    'start_time' => $slotStart->format('h:i A'),
                    'end_time' => $slotEnd->format('h:i A'),
                    'start_time_db' => $slotStart->format('H:i:s'),
                    'end_time_db' => $slotEnd->format('H:i:s'),
                    'available' => $available,
                    'is_full' => $available <= 0
                ];

                $start->addMinutes($window->slot_duration);
            }
        }

        return $slots;
    }
}
