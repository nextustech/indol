<?php

namespace App\Http\Controllers;

use App\Models\AvailabilityWindow;
use App\Models\Branch;
use App\Models\AppointmentType;
use Illuminate\Http\Request;

class AvailabilityWindowController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-trash-availability-window', ['only'=>['trash']]);
        $this->middleware('permission:restore-availability-window', ['only'=>['restore']]);
        $this->middleware('permission:force-delete-availability-window', ['only'=>['forceDelete']]);
    }
    public function index(Request $request)
    {
        $windows = AvailabilityWindow::with(['branch', 'appointmentType'])
            ->when($request->branch_id, fn ($q, $b) => $q->where('branch_id', $b))
            ->when($request->appointment_type_id, fn ($q, $t) => $q->where('appointment_type_id', $t))
            ->when($request->is_active !== null && $request->is_active !== '', fn ($q, $a) => $q->where('is_active', $a))
            ->orderBy('branch_id')
            ->orderBy('appointment_type_id')
            ->orderBy('day_of_week')
            ->paginate(15);

        $branches = Branch::orderBy('branchName')->get();
        $appointmentTypes = AppointmentType::where('is_active', 1)->orderBy('name')->get();

        return view('admin.availability-windows.index', compact('windows', 'branches', 'appointmentTypes'));
    }

    public function create()
    {
        $branches = Branch::orderBy('branchName')->get();
        $appointmentTypes = AppointmentType::where('is_active', 1)->orderBy('name')->get();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('admin.availability-windows.create', compact('branches', 'appointmentTypes', 'days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'slot_duration' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        AvailabilityWindow::create($validated);

        return redirect()->route('admin.availability-windows.index')
            ->with('success', 'Availability window created successfully.');
    }

    public function show(AvailabilityWindow $availabilityWindow)
    {
        $availabilityWindow->load(['branch', 'appointmentType']);
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('admin.availability-windows.show', compact('availabilityWindow', 'days'));
    }

    public function edit(AvailabilityWindow $availabilityWindow)
    {
        $branches = Branch::orderBy('branchName')->get();
        $appointmentTypes = AppointmentType::where('is_active', 1)->orderBy('name')->get();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('admin.availability-windows.edit', compact('availabilityWindow', 'branches', 'appointmentTypes', 'days'));
    }

    public function update(Request $request, AvailabilityWindow $availabilityWindow)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'slot_duration' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $availabilityWindow->update($validated);

        return redirect()->route('admin.availability-windows.index')
            ->with('success', 'Availability window updated successfully.');
    }

    public function destroy(AvailabilityWindow $availabilityWindow)
    {
        $availabilityWindow->deleteRecord();

        return redirect()->route('admin.availability-windows.index')
            ->with('success', 'Availability window deleted successfully.');
    }

    public function trash()
    {
        $windows = AvailabilityWindow::onlyDeleted()->latest('deleted_at')->paginate(15);
        return view('admin.availability-windows.trash', compact('windows'));
    }

    public function restore($id)
    {
        $window = AvailabilityWindow::withDeleted()->findOrFail($id);
        $window->restoreRecord();
        return redirect()->route('admin.availability-windows.trash')->with('success', 'Availability window restored successfully.');
    }

    public function forceDelete($id)
    {
        $window = AvailabilityWindow::withDeleted()->findOrFail($id);
        $window->forceDeleteRecord();
        return redirect()->route('admin.availability-windows.trash')->with('success', 'Availability window permanently deleted.');
    }
}