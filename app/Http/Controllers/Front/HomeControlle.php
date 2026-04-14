<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeControlle extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::where('status', 1)
            ->orderBy('order')
            ->get();

        return view('front.home', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function bookAppointment()
    {
        $branches = \App\Models\Branch::get();

        return view('front.book-appointment', compact('branches'));
    }

    public function appointmentConfirmation($id = null)
    {
        $appointment = $id
            ? Appointment::with(['branch', 'appointmentType'])->find($id)
            : null;

        $formatTime = function ($time) {
            if (empty($time)) {
                return null;
            }

            try {
                return Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
            } catch (\Throwable $exception) {
                return $time;
            }
        };

        $appointmentYear = $appointment?->appointment_date
            ? Carbon::parse($appointment->appointment_date)->format('Y')
            : now()->format('Y');

        $appointmentId = $appointment
            ? 'APT-'.$appointmentYear.'-'.str_pad((string) $appointment->id, 5, '0', STR_PAD_LEFT)
            : 'APT-'.$appointmentYear.'-78542';

        $appointmentDate = $appointment?->appointment_date
            ? Carbon::parse($appointment->appointment_date)
            : null;

        $patientName = $appointment?->patient_name ?? 'Sarah Mitchell';
        $appointmentTime = $appointment
            ? trim(($formatTime($appointment->start_time) ?? '').' - '.($formatTime($appointment->end_time) ?? ''), ' -')
            : '10:30 AM - 11:00 AM';

        $data = [
            'appointmentId' => $appointmentId,
            'patientName' => $patientName,
            'doctorName' => 'Front Desk Confirmation',
            'doctorSpecialty' => $appointment?->appointmentType?->name ?? 'Chiropractic Specialist',
            'appointmentDate' => $appointmentDate?->format('l, F j, Y') ?? 'Thursday, April 18, 2024',
            'appointmentDay' => $appointmentDate?->format('d') ?? '18',
            'appointmentMonthYear' => strtoupper($appointmentDate?->format('M Y') ?? 'APR 2024'),
            'appointmentTime' => $appointmentTime,
            'clinicName' => $appointment?->branch?->branchName ?? 'Downtown Spine & Wellness Center',
            'clinicAddress' => $appointment?->branch?->address ?? '245 Health Avenue, Suite 302',
            'calendarStart' => $appointmentDate
                ? $appointmentDate->format('Y-m-d').'T'.($appointment->start_time ?? '10:30:00')
                : '2024-04-18T10:30:00',
            'calendarEnd' => $appointmentDate
                ? $appointmentDate->format('Y-m-d').'T'.($appointment->end_time ?? '11:00:00')
                : '2024-04-18T11:00:00',
        ];

        return view('front.appointment-confirmation', $data);
    }
}
