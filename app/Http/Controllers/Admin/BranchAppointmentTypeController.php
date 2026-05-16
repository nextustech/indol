<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BranchAppointmentType;
use App\Models\Branch;
use App\Models\AppointmentType;
use Illuminate\Http\Request;

class BranchAppointmentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-trash-branch-appointment-type', ['only'=>['trash']]);
        $this->middleware('permission:restore-branch-appointment-type', ['only'=>['restore']]);
        $this->middleware('permission:force-delete-branch-appointment-type', ['only'=>['forceDelete']]);
    }
    public function index(Request $request)
    {
        $query = BranchAppointmentType::with(['branch', 'appointmentType']);

        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->appointment_type_id) {
            $query->where('appointment_type_id', $request->appointment_type_id);
        }

        $branchTypes = $query->orderBy('id', 'desc')->paginate(20);
        $branches = Branch::orderBy('branchName')->get();
        $appointmentTypes = AppointmentType::orderBy('name')->get();

        return view('admin.branch-appointment-types.index', compact('branchTypes', 'branches', 'appointmentTypes'));
    }

    public function create()
    {
        $branches = Branch::orderBy('branchName')->get();
        $appointmentTypes = AppointmentType::orderBy('name')->get();

        return view('admin.branch-appointment-types.create', compact('branches', 'appointmentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
        ]);

        $exists = BranchAppointmentType::where('branch_id', $request->branch_id)
            ->where('appointment_type_id', $request->appointment_type_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This appointment type is already assigned to the selected branch.');
        }

        BranchAppointmentType::create($request->only(['branch_id', 'appointment_type_id']));

        return redirect()->route('admin.branch-appointment-types.index')
            ->with('success', 'Appointment type assigned to branch successfully.');
    }

    public function show($id)
    {
        $branchType = BranchAppointmentType::with(['branch', 'appointmentType'])->findOrFail($id);

        return view('admin.branch-appointment-types.show', compact('branchType'));
    }

    public function edit($id)
    {
        $branchType = BranchAppointmentType::findOrFail($id);
        $branches = Branch::orderBy('branchName')->get();
        $appointmentTypes = AppointmentType::orderBy('name')->get();

        return view('admin.branch-appointment-types.edit', compact('branchType', 'branches', 'appointmentTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
        ]);

        $branchType = BranchAppointmentType::findOrFail($id);

        $exists = BranchAppointmentType::where('branch_id', $request->branch_id)
            ->where('appointment_type_id', $request->appointment_type_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This appointment type is already assigned to the selected branch.');
        }

        $branchType->update($request->only(['branch_id', 'appointment_type_id']));

        return redirect()->route('admin.branch-appointment-types.index')
            ->with('success', 'Assignment updated successfully.');
    }

    public function destroy($id)
    {
        $branchType = BranchAppointmentType::findOrFail($id);
        $branchType->deleteRecord();

        return redirect()->route('admin.branch-appointment-types.index')
            ->with('success', 'Assignment deleted successfully.');
    }

    public function trash()
    {
        $branchTypes = BranchAppointmentType::onlyDeleted()->latest('deleted_at')->get();
        return view('admin.branch-appointment-types.trash', compact('branchTypes'));
    }

    public function restore($id)
    {
        $branchType = BranchAppointmentType::withDeleted()->findOrFail($id);
        $branchType->restoreRecord();
        return redirect()->route('admin.branch-appointment-types.trash')->with('success', 'Assignment restored successfully.');
    }

    public function forceDelete($id)
    {
        $branchType = BranchAppointmentType::withDeleted()->findOrFail($id);
        $branchType->forceDeleteRecord();
        return redirect()->route('admin.branch-appointment-types.trash')->with('success', 'Assignment permanently deleted.');
    }
}