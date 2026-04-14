<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SlotService;
use App\Models\Appointment;
use App\Models\Holiday;
use App\Models\AvailabilityWindow;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * 🔹 Get Available Slots
     */
    public function getSlots(Request $request, SlotService $slotService)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'date' => 'required|date'
        ]);

        $slots = $slotService->getSlots(
            $request->branch_id,
            $request->appointment_type_id,
            $request->date
        );

        return response()->json([
            'status' => true,
            'data' => $slots
        ]);
    }

    /**
     * 🔹 Store Booking
     */
    public function bookAppointment(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'consultation_topic' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $date = $request->appointment_date;

            // 🔴 1. Check Full Day Holiday
            $isHoliday = Holiday::where('branch_id', $request->branch_id)
                ->whereDate('start_date', '<=', $date)
                ->where(function ($q) use ($date) {
                    $q->whereDate('end_date', '>=', $date)
                      ->orWhereNull('end_date');
                })
                ->where('is_full_day', true)
                ->exists();

            if ($isHoliday) {
                return response()->json([
                    'status' => false,
                    'message' => 'Clinic is closed on selected date'
                ], 422);
            }

            // 🟡 2. Get Day of Week
            $day = Carbon::parse($date)->dayOfWeek;

            // 🟢 3. Get Availability Window
            $window = AvailabilityWindow::where('branch_id', $request->branch_id)
                ->where('appointment_type_id', $request->appointment_type_id)
                ->where('day_of_week', $day)
                ->where('is_active', true)
                ->first();

            if (!$window) {
                return response()->json([
                    'status' => false,
                    'message' => 'No availability for selected day'
                ], 422);
            }

            // 🔵 4. Check Capacity (with lock)
            $bookedCount = Appointment::where('branch_id', $request->branch_id)
                ->where('appointment_type_id', $request->appointment_type_id)
                ->where('appointment_date', $date)
                ->where('start_time', $request->start_time)
                ->lockForUpdate()
                ->count();

            if ($bookedCount >= $window->capacity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Slot is already full'
                ], 422);
            }

            // 🟣 5. Save Appointment
            $appointment = Appointment::create([
                'patient_name' => $request->patient_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'consultation_topic' => $request->consultation_topic,
                'branch_id' => $request->branch_id,
                'appointment_type_id' => $request->appointment_type_id,
                'appointment_date' => $date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => 'booked'
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Appointment booked successfully',
                'data' => $appointment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getTypes(Request $request)
{
    $request->validate([
        'branch_id' => 'required|exists:branches,id'
    ]);

    $branch = Branch::with('appointmentTypes')->find($request->branch_id);

    return response()->json([
        'status' => true,
        'data' => $branch->appointmentTypes
    ]);
}
}
