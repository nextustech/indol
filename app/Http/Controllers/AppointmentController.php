<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\AppointmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::with(['branch', 'appointmentType'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->branch_id, fn ($q, $b) => $q->where('branch_id', $b))
            ->when($request->date_from, fn ($q, $d) => $q->where('appointment_date', '>=', $d))
            ->when($request->date_to, fn ($q, $d) => $q->where('appointment_date', '<=', $d))
            ->when($request->search, fn ($q, $s) => $q->where(fn ($q) => $q->where('patient_name', 'like', "%{$s}%")->orWhere('phone', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")))
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        $branches = Branch::orderBy('branchName')->get();
        $appointmentTypes = AppointmentType::where('is_active', 1)->orderBy('name')->get();

        return view('admin.appointments.index', compact('appointments', 'branches', 'appointmentTypes'));
    }

    public function create()
    {
        $branches = Branch::orderBy('branchName')->get();
        $appointmentTypes = AppointmentType::where('is_active', 1)->orderBy('name')->get();

        return view('admin.appointments.create', compact('branches', 'appointmentTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'required|string|max:20',
            'consultation_topic' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Appointment::create($validated + ['status' => 'booked']);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['branch', 'appointmentType']);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $branches = Branch::where('status', 1)->orderBy('branchName')->get();
        $appointmentTypes = AppointmentType::where('is_active', 1)->orderBy('name')->get();

        return view('admin.appointments.edit', compact('appointment', 'branches', 'appointmentTypes'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'required|string|max:20',
            'consultation_topic' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|in:booked,cancelled,completed',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:booked,cancelled,completed'
        ]);

        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Appointment status updated.');
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'date' => 'required|date'
        ]);

        $window = \App\Models\AvailabilityWindow::where('branch_id', $request->branch_id)
            ->where('appointment_type_id', $request->appointment_type_id)
            ->where('day_of_week', \Carbon\Carbon::parse($request->date)->dayOfWeek)
            ->where('is_active', true)
            ->first();

        if (!$window) {
            return response()->json(['success' => false, 'message' => 'No availability for this day']);
        }

        $bookedCount = Appointment::where('branch_id', $request->branch_id)
            ->where('appointment_type_id', $request->appointment_type_id)
            ->where('appointment_date', $request->date)
            ->where('status', 'booked')
            ->count();

        $remaining = $window->capacity - $bookedCount;

        $slots = [];
        $current = strtotime($window->start_time);
        $end = strtotime($window->end_time);
        $duration = $window->duration ?? 30;

        while ($current < $end) {
            $start = date('H:i:s', $current);
            $endTime = date('H:i:s', $current + ($duration * 60));

            if ($endTime <= $end) {
                $slots[] = [
                    'start_time' => $start,
                    'end_time' => $endTime,
                    'remaining' => $remaining > 0 ? $remaining : 0,
                    'available' => $remaining > 0
                ];
            }

            $current += ($duration * 60);
        }

        return response()->json(['success' => true, 'slots' => $slots, 'remaining' => $remaining]);
    }
}