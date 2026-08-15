<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\ExercisePrescription;
use App\Models\Investigation;
use App\Models\Patient;
use App\Models\Branch;
use App\Models\DropdownOption;
use App\Models\TreatmentPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-Assessment', ['only' => ['index']]);
        $this->middleware('permission:create-Assessment', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-Assessment', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-Assessment', ['only' => ['destroy']]);
        $this->middleware('permission:show-AssessmentProfile', ['only' => ['show']]);
        $this->middleware('permission:print-Assessment', ['only' => ['print']]);
        $this->middleware('permission:view-trash-assessment', ['only' => ['trash']]);
        $this->middleware('permission:restore-assessment', ['only' => ['restore', 'bulkRestore']]);
        $this->middleware('permission:force-delete-assessment', ['only' => ['forceDelete', 'bulkForceDelete']]);
    }

    public function index(Request $request)
    {
        $user = loggedUser();
        $branchIds = $user->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id', $branchIds)->orderBy('branchName')->get();

        $query = Assessment::with(['patient', 'branch', 'assessedBy'])
            ->whereIn('branch_id', $branchIds);

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            $query->where('assessed_by', $user->id);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('assessment_date', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59',
            ]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('patientId', 'LIKE', '%' . $search . '%')
                    ->orWhere('mobile', 'LIKE', '%' . $search . '%');
            });
        }

        $assessments = $query->latest('assessment_date')->paginate(20);

        return view('assessments.index', compact('assessments', 'branches'));
    }

    public function create(Request $request)
    {
        $user = loggedUser();
        $branchIds = $user->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id', $branchIds)->orderBy('branchName')->get();
        $selectedPatient = null;

        if ($request->filled('patient_id')) {
            $selectedPatient = Patient::find($request->patient_id);
        }

        return view('assessments.create', array_merge(compact('branches', 'selectedPatient'), $this->dropdownGroups()));
    }

    public function store(Request $request)
    {
        $rules = [
            'patient_id' => 'required|exists:patients,id',
            'branch_id' => 'required|exists:branches,id',
            'assessment_date' => 'required|date',
            'type' => 'required|in:initial,follow-up,discharge',
            'status' => 'required|in:draft,completed',
        ];

        $messages = [
            'patient_id.required' => 'Please select a patient',
            'branch_id.required' => 'Please select a branch',
            'assessment_date.required' => 'Please select assessment date',
        ];

        $this->validate($request, $rules, $messages);

        $data = $request->all();
        $data['assessed_by'] = Auth::id();
        $dt = date('Y-m-d', strtotime($data['assessment_date']));
        $data['assessment_date'] = Carbon::createFromFormat('Y-m-d H', $dt . ' 00');

        $assessment = Assessment::create($data);

        if ($assessment) {
            $this->saveInvestigations($request, $assessment);
            $this->saveTreatmentPlan($request, $assessment);
            return redirect()->route('assessments.show', $assessment->id)
                ->with('message', 'Assessment Created Successfully');
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function show(Assessment $assessment)
    {
        $user = loggedUser();

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist' && $assessment->assessed_by !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        $assessment->load(['patient', 'branch', 'assessedBy', 'investigations', 'treatmentPlan.exercises']);

        return view('assessments.show', compact('assessment'));
    }

    public function edit(Assessment $assessment)
    {
        $user = loggedUser();
        $branchIds = $user->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id', $branchIds)->orderBy('branchName')->get();

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist' && $assessment->assessed_by !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        $assessment->load(['investigations', 'treatmentPlan.exercises']);

        return view('assessments.edit', array_merge(compact('assessment', 'branches'), $this->dropdownGroups()));
    }

    public function update(Request $request, Assessment $assessment)
    {
        $user = loggedUser();

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist' && $assessment->assessed_by !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        $rules = [
            'branch_id' => 'required|exists:branches,id',
            'assessment_date' => 'required|date',
            'type' => 'required|in:initial,follow-up,discharge',
            'status' => 'required|in:draft,completed',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $dt = date('Y-m-d', strtotime($data['assessment_date']));
        $data['assessment_date'] = Carbon::createFromFormat('Y-m-d H', $dt . ' 00');

        if ($assessment->update($data)) {
            $this->saveInvestigations($request, $assessment);
            $this->saveTreatmentPlan($request, $assessment);
            return redirect()->route('assessments.show', $assessment->id)
                ->with('message', 'Assessment Updated Successfully');
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function destroy(Assessment $assessment)
    {
        $assessment->deleteRecord();
        return redirect()->route('assessments.index')->with('message', 'Assessment Deleted Successfully');
    }

    public function trash()
    {
        $assessments = Assessment::onlyDeleted()->with(['patient', 'branch', 'assessedBy'])->latest('deleted_at')->paginate(20);
        return view('assessments.trash', compact('assessments'));
    }

    public function restore($id)
    {
        $assessment = Assessment::withDeleted()->findOrFail($id);
        $assessment->restoreRecord();
        return redirect()->route('assessments.trash')->with('message', 'Assessment Restored Successfully');
    }

    public function forceDelete($id)
    {
        $assessment = Assessment::withDeleted()->findOrFail($id);
        $assessment->forceDeleteRecord();
        return redirect()->route('assessments.trash')->with('message', 'Assessment Permanently Deleted');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Assessment::whereIn('id', $request->ids)->each(fn($a) => $a->deleteRecord());
        return back()->with('message', count($request->ids) . ' assessments deleted successfully');
    }

    public function bulkRestore(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Assessment::onlyDeleted()->whereIn('id', $request->ids)->each(fn($a) => $a->restoreRecord());
        return back()->with('message', count($request->ids) . ' assessments restored successfully');
    }

    public function bulkForceDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Assessment::onlyDeleted()->whereIn('id', $request->ids)->each(fn($a) => $a->forceDeleteRecord());
        return back()->with('message', count($request->ids) . ' assessments permanently deleted');
    }

    public function print($id)
    {
        $assessment = Assessment::with(['patient', 'branch', 'assessedBy', 'investigations', 'treatmentPlan.exercises'])
            ->withDeleted()->findOrFail($id);

        return view('assessments.print', compact('assessment'));
    }

    private function dropdownGroups()
    {
        return [
            'investigationTypes' => DropdownOption::where('type', 'investigation_type')->orderBy('name')->pluck('name'),
            'exerciseNames' => DropdownOption::where('type', 'exercise_name')->orderBy('name')->pluck('name'),
            'exerciseCategories' => DropdownOption::where('type', 'exercise_category')->orderBy('name')->pluck('name'),
            'specialTests' => DropdownOption::where('type', 'special_test')->orderBy('name')->pluck('name'),
            'clinicalImpressions' => DropdownOption::where('type', 'clinical_impression')->orderBy('name')->pluck('name'),
            'complaints' => DropdownOption::where('type', 'complaint')->orderBy('name')->pluck('name'),
        ];
    }

    private function saveInvestigations(Request $request, Assessment $assessment)
    {
        if (!$request->has('investigations')) {
            return;
        }

        $assessment->investigations()->each(fn($inv) => $inv->deleteRecord());

        foreach ($request->investigations as $inv) {
            if (!empty($inv['type'])) {
                Investigation::create([
                    'assessment_id' => $assessment->id,
                    'type' => $inv['type'],
                    'investigation_date' => $inv['date'] ?? null,
                    'findings' => $inv['findings'] ?? null,
                    'facility' => $inv['facility'] ?? null,
                ]);
            }
        }
    }

    private function saveTreatmentPlan(Request $request, Assessment $assessment)
    {
        $hasPlanData = $request->filled('short_term_goals')
            || $request->filled('long_term_goals')
            || $request->filled('precautions')
            || $request->filled('advice')
            || $request->filled('follow_up_instructions')
            || ($request->has('exercises') && collect($request->exercises)->pluck('exercise_name')->filter()->isNotEmpty());

        if (!$hasPlanData) {
            return;
        }

        $plan = $assessment->treatmentPlan;

        if ($plan) {
            $plan->update([
                'short_term_goals' => $request->short_term_goals,
                'long_term_goals' => $request->long_term_goals,
                'precautions' => $request->precautions,
                'advice' => $request->advice,
                'follow_up_instructions' => $request->follow_up_instructions,
            ]);
        } else {
            $plan = TreatmentPlan::create([
                'assessment_id' => $assessment->id,
                'patient_id' => $assessment->patient_id,
                'short_term_goals' => $request->short_term_goals,
                'long_term_goals' => $request->long_term_goals,
                'precautions' => $request->precautions,
                'advice' => $request->advice,
                'follow_up_instructions' => $request->follow_up_instructions,
                'status' => 'active',
                'created_by' => Auth::id(),
            ]);
        }

        if ($request->has('exercises')) {
            $existingIds = $plan->exercises->pluck('id')->toArray();
            $submittedIds = [];

            foreach ($request->exercises as $ex) {
                if (!empty($ex['exercise_name'])) {
                    if (!empty($ex['id']) && in_array($ex['id'], $existingIds)) {
                        $exercise = ExercisePrescription::find($ex['id']);
                        if ($exercise) {
                            $exercise->update($ex);
                            $submittedIds[] = $ex['id'];
                        }
                    } else {
                        $ex['treatment_plan_id'] = $plan->id;
                        $newEx = ExercisePrescription::create($ex);
                        $submittedIds[] = $newEx->id;
                    }
                }
            }

            $toDelete = array_diff($existingIds, $submittedIds);
            if (!empty($toDelete)) {
                ExercisePrescription::whereIn('id', $toDelete)->each(fn($ex) => $ex->deleteRecord());
            }
        }
    }
}
