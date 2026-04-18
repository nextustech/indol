<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\Branch;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $holidays = Holiday::with('branch')
            ->when($request->branch_id, fn ($q, $b) => $q->where('branch_id', $b))
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        $branches = Branch::orderBy('branchName')->get();

        return view('admin.holidays.index', compact('holidays', 'branches'));
    }

    public function create()
    {
        $branches = Branch::orderBy('branchName')->get();
        return view('admin.holidays.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:191',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'is_full_day' => 'boolean',
            'is_recurring' => 'boolean',
        ]);

        Holiday::create($validated);

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday created successfully.');
    }

    public function show(Holiday $holiday)
    {
        $holiday->load('branch');
        return view('admin.holidays.show', compact('holiday'));
    }

    public function edit(Holiday $holiday)
    {
        $branches = Branch::orderBy('branchName')->get();
        return view('admin.holidays.edit', compact('holiday', 'branches'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:191',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'is_full_day' => 'boolean',
            'is_recurring' => 'boolean',
        ]);

        $holiday->update($validated);

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday updated successfully.');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday deleted successfully.');
    }
}