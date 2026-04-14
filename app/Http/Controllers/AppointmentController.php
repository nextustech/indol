<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Slot;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'branch', 'doctor', 'slot'])->latest()->get();
        return view('admin.appointments.index', compact('appointments'));
    }
    
    public function create()
    {
        return view('front.appointment');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'branch_id' => ['required', 'exists:branches,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'slot_id' => ['required', 'exists:slots,id'],
            'type' => ['required', 'in:home_visit,video_consultation,at_clinic'],
            'service' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            $patient = Patient::where('phone', $validated['phone'])
                ->orWhere('mobile', $validated['phone'])
                ->first();

            if (! $patient) {
                $nextPatientId = ((int) Patient::max('patientId')) + 1;

                $patient = Patient::create([
                    'patientId' => str_pad((string) $nextPatientId, 4, '0', STR_PAD_LEFT),
                    'name' => ucwords($validated['name']),
                    'age' => 0,
                    'phone' => $validated['phone'],
                    'mobile' => $validated['phone'],
                    'address' => 'N.A',
                    'date' => Carbon::now(),
                    'ref_by' => 'Appointment',
                ]);
            }

            if (! $patient->branches()->where('branches.id', $validated['branch_id'])->exists()) {
                $patient->branches()->attach($validated['branch_id']);
            }

            $slot = Slot::where('id', $validated['slot_id'])
                ->where('branch_id', $validated['branch_id'])
                ->where('is_active', true)
                ->firstOrFail();

            $count = Appointment::where('appointment_date', $validated['date'])
                ->where('slot_id', $slot->id)
                ->count();

            if ($count >= $slot->max_booking) {
                return response()->json(['error' => 'Slot full'], 422);
            }

            Appointment::create([
                'full_name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'],
                'patient_id' => $patient->id,
                'branch_id' => $validated['branch_id'],
                'doctor_id' => $slot->doctor_id,
                'slot_id' => $slot->id,
                'appointment_date' => $validated['date'],
                'appointment_time' => $slot->start_time,
                'type' => $validated['type'],
                'service' => $validated['service']
            ]);

            // 🔥 WhatsApp (simple)
            // app(WhatsAppService::class)->send($patient->phone, "Appointment confirmed");

            DB::commit();

            return response()->json(['success' => true], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
