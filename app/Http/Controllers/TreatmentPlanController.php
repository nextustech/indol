<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\TreatmentPlan;
use App\Models\ExercisePrescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreatmentPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-TreatmentPlan', ['only' => ['index']]);
        $this->middleware('permission:create-TreatmentPlan', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-TreatmentPlan', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-TreatmentPlan', ['only' => ['destroy']]);
        $this->middleware('permission:view-trash-treatment-plan', ['only' => ['trash']]);
        $this->middleware('permission:restore-treatment-plan', ['only' => ['restore', 'bulkRestore']]);
        $this->middleware('permission:force-delete-treatment-plan', ['only' => ['forceDelete', 'bulkForceDelete']]);
    }

    public function index()
    {
        $user = loggedUser();
        $branchIds = $user->branches->pluck('id')->toArray();

        $query = TreatmentPlan::with(['patient', 'assessment', 'creator'])
            ->whereHas('assessment', function ($q) use ($branchIds) {
                $q->whereIn('branch_id', $branchIds);
            });

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            $query->where('created_by', $user->id);
        }

        $plans = $query->latest()->paginate(20);

        return view('treatment_plans.index', compact('plans'));
    }

    public function create(Request $request)
    {
        $assessment = null;
        if ($request->filled('assessment_id')) {
            $assessment = Assessment::with('patient')->findOrFail($request->assessment_id);
        }

        return view('treatment_plans.create', compact('assessment'));
    }

    public function store(Request $request)
    {
        $rules = [
            'assessment_id' => 'required|exists:assessments,id',
            'patient_id' => 'required|exists:patients,id',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        $plan = TreatmentPlan::create($data);

        if ($request->has('exercises')) {
            foreach ($request->exercises as $exercise) {
                if (!empty($exercise['exercise_name'])) {
                    $plan->exercises()->create($exercise);
                }
            }
        }

        if ($plan) {
            return redirect()->route('assessments.show', $plan->assessment_id)
                ->with('message', 'Treatment Plan Created Successfully');
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function show(TreatmentPlan $treatmentPlan)
    {
        $treatmentPlan->load(['patient', 'assessment', 'creator', 'exercises']);
        return view('treatment_plans.show', compact('treatmentPlan'));
    }

    public function edit(TreatmentPlan $treatmentPlan)
    {
        $treatmentPlan->load(['assessment.patient', 'exercises']);
        return view('treatment_plans.edit', compact('treatmentPlan'));
    }

    public function update(Request $request, TreatmentPlan $treatmentPlan)
    {
        $data = $request->except(['exercises']);
        $treatmentPlan->update($data);

        if ($request->has('exercises')) {
            $existingIds = $treatmentPlan->exercises->pluck('id')->toArray();
            $submittedIds = [];

            foreach ($request->exercises as $exercise) {
                if (!empty($exercise['exercise_name'])) {
                    if (!empty($exercise['id']) && in_array($exercise['id'], $existingIds)) {
                        $ex = ExercisePrescription::find($exercise['id']);
                        if ($ex) {
                            $ex->update($exercise);
                            $submittedIds[] = $exercise['id'];
                        }
                    } else {
                        $exercise['treatment_plan_id'] = $treatmentPlan->id;
                        $newEx = ExercisePrescription::create($exercise);
                        $submittedIds[] = $newEx->id;
                    }
                }
            }

            $toDelete = array_diff($existingIds, $submittedIds);
            if (!empty($toDelete)) {
                ExercisePrescription::whereIn('id', $toDelete)->each(fn($ex) => $ex->deleteRecord());
            }
        }

        return redirect()->route('assessments.show', $treatmentPlan->assessment_id)
            ->with('message', 'Treatment Plan Updated Successfully');
    }

    public function destroy(TreatmentPlan $treatmentPlan)
    {
        $treatmentPlan->deleteRecord();
        return redirect()->route('treatment-plans.index')->with('message', 'Treatment Plan Deleted Successfully');
    }

    public function trash()
    {
        $plans = TreatmentPlan::onlyDeleted()->with(['patient', 'assessment'])->latest('deleted_at')->paginate(20);
        return view('treatment_plans.trash', compact('plans'));
    }

    public function restore($id)
    {
        $plan = TreatmentPlan::withDeleted()->findOrFail($id);
        $plan->restoreRecord();
        return redirect()->route('treatment-plans.trash')->with('message', 'Treatment Plan Restored Successfully');
    }

    public function forceDelete($id)
    {
        $plan = TreatmentPlan::withDeleted()->findOrFail($id);
        $plan->forceDeleteRecord();
        return redirect()->route('treatment-plans.trash')->with('message', 'Treatment Plan Permanently Deleted');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        TreatmentPlan::whereIn('id', $request->ids)->each(fn($p) => $p->deleteRecord());
        return back()->with('message', count($request->ids) . ' treatment plans deleted successfully');
    }

    public function bulkRestore(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        TreatmentPlan::onlyDeleted()->whereIn('id', $request->ids)->each(fn($p) => $p->restoreRecord());
        return back()->with('message', count($request->ids) . ' treatment plans restored successfully');
    }

    public function bulkForceDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        TreatmentPlan::onlyDeleted()->whereIn('id', $request->ids)->each(fn($p) => $p->forceDeleteRecord());
        return back()->with('message', count($request->ids) . ' treatment plans permanently deleted');
    }
}
