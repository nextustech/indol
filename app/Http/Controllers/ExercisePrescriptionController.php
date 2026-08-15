<?php

namespace App\Http\Controllers;

use App\Models\ExercisePrescription;
use App\Models\TreatmentPlan;
use Illuminate\Http\Request;

class ExercisePrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:edit-TreatmentPlan', ['only' => ['store', 'update', 'destroy']]);
    }

    public function store(Request $request, TreatmentPlan $treatmentPlan)
    {
        $request->validate([
            'exercise_name' => 'required|string|max:255',
        ]);

        $exercise = $treatmentPlan->exercises()->create($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'exercise' => $exercise]);
        }

        return redirect()->back()->with('message', 'Exercise added successfully');
    }

    public function update(Request $request, ExercisePrescription $exercise)
    {
        $request->validate([
            'exercise_name' => 'required|string|max:255',
        ]);

        $exercise->update($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'exercise' => $exercise]);
        }

        return redirect()->back()->with('message', 'Exercise updated successfully');
    }

    public function destroy(ExercisePrescription $exercise)
    {
        $exercise->deleteRecord();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('message', 'Exercise deleted successfully');
    }
}
