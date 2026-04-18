<?php

namespace App\Http\Controllers;

use App\Models\AppointmentType;
use Illuminate\Http\Request;

class AppointmentTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = AppointmentType::when($request->search, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->is_active !== null && $request->is_active !== '', fn ($q, $a) => $q->where('is_active', $a))
            ->orderBy('name')
            ->paginate(15);

        return view('admin.appointment-types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.appointment-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'duration' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        AppointmentType::create($validated);

        return redirect()->route('admin.appointment-types.index')
            ->with('success', 'Appointment type created successfully.');
    }

    public function show(AppointmentType $appointmentType)
    {
        return view('admin.appointment-types.show', compact('appointmentType'));
    }

    public function edit(AppointmentType $appointmentType)
    {
        return view('admin.appointment-types.edit', compact('appointmentType'));
    }

    public function update(Request $request, AppointmentType $appointmentType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'duration' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $appointmentType->update($validated);

        return redirect()->route('admin.appointment-types.index')
            ->with('success', 'Appointment type updated successfully.');
    }

    public function destroy(AppointmentType $appointmentType)
    {
        $appointmentType->delete();

        return redirect()->route('admin.appointment-types.index')
            ->with('success', 'Appointment type deleted successfully.');
    }
}