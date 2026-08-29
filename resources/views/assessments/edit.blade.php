@extends('layouts.backend')
@section('page-css')
<style>
    .section-card { margin-bottom: 1rem; }
    .section-card .card-header { padding: .5rem 1rem; cursor: pointer; }
    .section-card .card-header .fas { transition: transform .3s; }
    .section-card.collapsed .card-header .fas.fa-chevron-down { transform: rotate(-90deg); }
    .investigation-row, .exercise-row { margin-bottom: .5rem; padding-bottom: .5rem; border-bottom: 1px dashed #dee2e6; }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Edit Assessment - {{ $assessment->patient->name ?? '' }}</h5>
                        </div>
                        {{ Html()->form('PUT')->route('assessments.update', $assessment->id)->open() }}
                        <div class="card-body">
                            @include('errors.list')

                            <div class="card section-card">
                                <div class="card-header bg-secondary" data-toggle="collapse" data-target="#patientSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Patient Information</h6>
                                </div>
                                <div id="patientSection" class="collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Patient</label>
                                                <input type="text" class="form-control" value="{{ $assessment->patient->name ?? 'N/A' }} ({{ $assessment->patient->patientId ?? 'N/A' }})" readonly>
                                                <input type="hidden" name="patient_id" value="{{ $assessment->patient_id }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Branch <span class="text-danger">*</span></label>
                                                <select name="branch_id" class="form-control" required>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ $assessment->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->branchName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Date <span class="text-danger">*</span></label>
                                                <input type="date" name="assessment_date" class="form-control" value="{{ $assessment->assessment_date->format('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4">
                                                <label>Type <span class="text-danger">*</span></label>
                                                <select name="type" class="form-control" required>
                                                    <option value="initial" {{ $assessment->type == 'initial' ? 'selected' : '' }}>Initial</option>
                                                    <option value="follow-up" {{ $assessment->type == 'follow-up' ? 'selected' : '' }}>Follow-up</option>
                                                    <option value="discharge" {{ $assessment->type == 'discharge' ? 'selected' : '' }}>Discharge</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Status</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="draft" {{ $assessment->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="completed" {{ $assessment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card section-card">
                                <div class="card-header bg-info" data-toggle="collapse" data-target="#ccSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Chief Complaints</h6>
                                </div>
                                <div id="ccSection" class="collapse show">
                                    <div class="card-body">
                                        <div id="complaints-container">
                                            @php
                                                $ccLines = $assessment->chief_complaints
                                                    ? array_filter(array_map('trim', explode("\n", $assessment->chief_complaints)))
                                                    : [];
                                            @endphp
                                            @forelse($ccLines as $i => $cc)
                                            <div class="complaint-row row">
                                                <div class="col-md-11">
                                                    <select name="complaints[{{ $i }}][complaint]" class="form-control cc-type-select" data-placeholder="Chief complaint...">
                                                        <option value=""></option>
                                                        @foreach($complaints as $c)
                                                            <option value="{{ $c }}" {{ $cc == $c ? 'selected' : '' }}>{{ $c }}</option>
                                                        @endforeach
                                                        @if($cc && !$complaints->contains($cc))
                                                            <option value="{{ $cc }}" selected>{{ $cc }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-complaint"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="complaint-row row">
                                                <div class="col-md-11">
                                                    <select name="complaints[0][complaint]" class="form-control cc-type-select" data-placeholder="Chief complaint...">
                                                        <option value=""></option>
                                                        @foreach($complaints as $c)
                                                            <option value="{{ $c }}">{{ $c }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-complaint"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            @endforelse
                                        </div>
                                        <button type="button" id="add-complaint" class="btn btn-sm btn-success mt-2"><i class="fa fa-plus"></i> Add Complaint</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card section-card">
                                <div class="card-header bg-info" data-toggle="collapse" data-target="#historySection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> History of Present Illness</h6>
                                </div>
                                <div id="historySection" class="collapse show">
                                    <div class="card-body">
                                        <textarea name="history_of_present_illness" class="form-control" rows="4">{{ $assessment->history_of_present_illness }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card section-card">
                                <div class="card-header bg-success" data-toggle="collapse" data-target="#examSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Objective Examination</h6>
                                </div>
                                <div id="examSection" class="collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Observation</label>
                                                <textarea name="observation" class="form-control" rows="3">{{ $assessment->observation }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Palpation</label>
                                                <textarea name="palpation" class="form-control" rows="3">{{ $assessment->palpation }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Range of Motion</label>
                                                <textarea name="range_of_motion" class="form-control" rows="3">{{ $assessment->range_of_motion }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Muscle Strength</label>
                                                <textarea name="muscle_strength" class="form-control" rows="3">{{ $assessment->muscle_strength }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Special Tests</label>
                                                <div id="special-tests-container">
                                                    @php
                                                        $stLines = $assessment->special_tests
                                                            ? array_filter(array_map('trim', explode("\n", $assessment->special_tests)))
                                                            : [];
                                                    @endphp
                                                    @forelse($stLines as $i => $st)
                                                    <div class="special-test-row row mb-1">
                                                        <div class="col-md-11">
                                                            <select name="specialTests[{{ $i }}][test]" class="form-control st-type-select" data-placeholder="Special test...">
                                                                <option value=""></option>
                                                                @foreach($specialTests as $opt)
                                                                    <option value="{{ $opt }}" {{ $st == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                                @endforeach
                                                                @if($st && !$specialTests->contains($st))
                                                                    <option value="{{ $st }}" selected>{{ $st }}</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger btn-sm remove-special-test"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div class="special-test-row row mb-1">
                                                        <div class="col-md-11">
                                                            <select name="specialTests[0][test]" class="form-control st-type-select" data-placeholder="Special test...">
                                                                <option value=""></option>
                                                                @foreach($specialTests as $st)
                                                                    <option value="{{ $st }}">{{ $st }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger btn-sm remove-special-test"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endforelse
                                                </div>
                                                <button type="button" id="add-special-test" class="btn btn-sm btn-success mt-1"><i class="fa fa-plus"></i> Add</button>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Neurological</label>
                                                <textarea name="neurological" class="form-control" rows="3">{{ $assessment->neurological }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Postural Assessment</label>
                                                <textarea name="postural_assessment" class="form-control" rows="3">{{ $assessment->postural_assessment }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Clinical Impression</label>
                                                <div id="clinical-impressions-container">
                                                    @php
                                                        $ciLines = $assessment->clinical_impression
                                                            ? array_filter(array_map('trim', explode("\n", $assessment->clinical_impression)))
                                                            : [];
                                                    @endphp
                                                    @forelse($ciLines as $i => $ci)
                                                    <div class="clinical-impression-row row mb-1">
                                                        <div class="col-md-11">
                                                            <select name="clinicalImpressions[{{ $i }}][impression]" class="form-control ci-type-select" data-placeholder="Clinical impression...">
                                                                <option value=""></option>
                                                                @foreach($clinicalImpressions as $opt)
                                                                    <option value="{{ $opt }}" {{ $ci == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                                @endforeach
                                                                @if($ci && !$clinicalImpressions->contains($ci))
                                                                    <option value="{{ $ci }}" selected>{{ $ci }}</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger btn-sm remove-clinical-impression"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div class="clinical-impression-row row mb-1">
                                                        <div class="col-md-11">
                                                            <select name="clinicalImpressions[0][impression]" class="form-control ci-type-select" data-placeholder="Clinical impression...">
                                                                <option value=""></option>
                                                                @foreach($clinicalImpressions as $ci)
                                                                    <option value="{{ $ci }}">{{ $ci }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger btn-sm remove-clinical-impression"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endforelse
                                                </div>
                                                <button type="button" id="add-clinical-impression" class="btn btn-sm btn-success mt-1"><i class="fa fa-plus"></i> Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Investigations --}}
                            <div class="card section-card">
                                <div class="card-header bg-warning" data-toggle="collapse" data-target="#investigationSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Investigations</h6>
                                </div>
                                <div id="investigationSection" class="collapse">
                                    <div class="card-body">
                                        <div id="investigations-container">
                                            @forelse($assessment->investigations as $i => $inv)
                                            <div class="investigation-row row">
                                                <div class="col-md-3">
                                                    <select name="investigations[{{ $i }}][type]" class="form-control inv-type-select" data-placeholder="Type (MRI, X-ray, etc.)">
                                                        <option value=""></option>
                                                        @foreach($investigationTypes as $invType)
                                                            <option value="{{ $invType }}" {{ $inv->type == $invType ? 'selected' : '' }}>{{ $invType }}</option>
                                                        @endforeach
                                                        @if($inv->type && !$investigationTypes->contains($inv->type))
                                                            <option value="{{ $inv->type }}" selected>{{ $inv->type }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="date" name="investigations[{{ $i }}][date]" class="form-control" value="{{ $inv->investigation_date ? $inv->investigation_date->format('Y-m-d') : '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="investigations[{{ $i }}][findings]" class="form-control" value="{{ $inv->findings }}" placeholder="Findings">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="investigations[{{ $i }}][facility]" class="form-control" value="{{ $inv->facility }}" placeholder="Facility">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-investigation"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="investigation-row row">
                                                <div class="col-md-3">
                                                    <select name="investigations[0][type]" class="form-control inv-type-select" data-placeholder="Type (MRI, X-ray, etc.)">
                                                        <option value=""></option>
                                                        @foreach($investigationTypes as $invType)
                                                            <option value="{{ $invType }}">{{ $invType }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="date" name="investigations[0][date]" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="investigations[0][findings]" class="form-control" placeholder="Findings">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="investigations[0][facility]" class="form-control" placeholder="Facility">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-investigation"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            @endforelse
                                        </div>
                                        <button type="button" id="add-investigation" class="btn btn-sm btn-success mt-2"><i class="fa fa-plus"></i> Add Investigation</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Treatment Plan --}}
                            <div class="card section-card">
                                <div class="card-header bg-danger" data-toggle="collapse" data-target="#treatmentSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Treatment Plan</h6>
                                </div>
                                <div id="treatmentSection" class="collapse">
                                    <div class="card-body">
                                        @php $plan = $assessment->treatmentPlan; @endphp
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Short-term Goals</label>
                                                <textarea name="short_term_goals" class="form-control" rows="3" placeholder="e.g., Reduce pain to 3/10 in 2 weeks">{{ $plan->short_term_goals ?? '' }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Long-term Goals</label>
                                                <textarea name="long_term_goals" class="form-control" rows="3" placeholder="e.g., Return to work without restriction in 8 weeks">{{ $plan->long_term_goals ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Precautions / Avoid</label>
                                                <div id="precautions-container">
                                                    @php
                                                        $pLines = ($plan->precautions ?? '')
                                                            ? array_filter(array_map('trim', explode("\n", $plan->precautions)))
                                                            : [];
                                                    @endphp
                                                    @forelse($pLines as $i => $p)
                                                    <div class="precaution-row row mb-1">
                                                        <div class="col-md-11">
                                                            <select name="precautionList[{{ $i }}][precaution]" class="form-control precaution-type-select" data-placeholder="Precaution...">
                                                                <option value=""></option>
                                                                @foreach($precautions as $opt)
                                                                    <option value="{{ $opt }}" {{ $p == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                                @endforeach
                                                                @if($p && !$precautions->contains($p))
                                                                    <option value="{{ $p }}" selected>{{ $p }}</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger btn-sm remove-precaution"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div class="precaution-row row mb-1">
                                                        <div class="col-md-11">
                                                            <select name="precautionList[0][precaution]" class="form-control precaution-type-select" data-placeholder="Precaution...">
                                                                <option value=""></option>
                                                                @foreach($precautions as $p)
                                                                    <option value="{{ $p }}">{{ $p }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger btn-sm remove-precaution"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endforelse
                                                </div>
                                                <button type="button" id="add-precaution" class="btn btn-sm btn-success mt-1"><i class="fa fa-plus"></i> Add</button>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Advice</label>
                                                <div id="advices-container">
                                                    @php
                                                        $aLines = ($plan->advice ?? '')
                                                            ? array_filter(array_map('trim', explode("\n", $plan->advice)))
                                                            : [];
                                                    @endphp
                                                    @forelse($aLines as $i => $a)
                                                    <div class="advice-row row mb-1">
                                                        <div class="col-md-11">
                                                            <select name="adviceList[{{ $i }}][advice]" class="form-control advice-type-select" data-placeholder="Advice...">
                                                                <option value=""></option>
                                                                @foreach($advices as $opt)
                                                                    <option value="{{ $opt }}" {{ $a == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                                @endforeach
                                                                @if($a && !$advices->contains($a))
                                                                    <option value="{{ $a }}" selected>{{ $a }}</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger btn-sm remove-advice"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div class="advice-row row mb-1">
                                                        <div class="col-md-11">
                                                            <select name="adviceList[0][advice]" class="form-control advice-type-select" data-placeholder="Advice...">
                                                                <option value=""></option>
                                                                @foreach($advices as $a)
                                                                    <option value="{{ $a }}">{{ $a }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger btn-sm remove-advice"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endforelse
                                                </div>
                                                <button type="button" id="add-advice" class="btn btn-sm btn-success mt-1"><i class="fa fa-plus"></i> Add</button>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <label>Follow-up Instructions</label>
                                                <textarea name="follow_up_instructions" class="form-control" rows="2" placeholder="Frequency of visits, next review date...">{{ $plan->follow_up_instructions ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Exercises --}}
                                        <hr>
                                        <h6>Exercise Prescription</h6>
                                        <div id="exercises-container">
                                            @php $exCount = 0; @endphp
                                            @if($plan && $plan->exercises->count() > 0)
                                                @foreach($plan->exercises as $ex)
                                            <div class="exercise-row row">
                                                <div class="col-md-3">
                                                    <input type="hidden" name="exercises[{{ $exCount }}][id]" value="{{ $ex->id }}">
                                                    <select name="exercises[{{ $exCount }}][exercise_name]" class="form-control ex-name-select" data-placeholder="Exercise name">
                                                        <option value=""></option>
                                                        @foreach($exerciseNames as $exName)
                                                            <option value="{{ $exName }}" {{ $ex->exercise_name == $exName ? 'selected' : '' }}>{{ $exName }}</option>
                                                        @endforeach
                                                        @if($ex->exercise_name && !$exerciseNames->contains($ex->exercise_name))
                                                            <option value="{{ $ex->exercise_name }}" selected>{{ $ex->exercise_name }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="exercises[{{ $exCount }}][sets]" class="form-control" value="{{ $ex->sets }}" placeholder="Sets">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="exercises[{{ $exCount }}][repetitions]" class="form-control" value="{{ $ex->repetitions }}" placeholder="Reps">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="exercises[{{ $exCount }}][frequency]" class="form-control" value="{{ $ex->frequency }}" placeholder="Frequency">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="exercises[{{ $exCount }}][duration]" class="form-control" value="{{ $ex->duration }}" placeholder="Duration">
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="exercises[{{ $exCount }}][category]" class="form-control ex-category-select" data-placeholder="Category">
                                                        <option value=""></option>
                                                        @foreach($exerciseCategories as $cat)
                                                            <option value="{{ $cat }}" {{ $ex->category == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                                                        @endforeach
                                                        @if($ex->category && !$exerciseCategories->contains($ex->category))
                                                            <option value="{{ $ex->category }}" selected>{{ ucfirst($ex->category) }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-exercise"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                                    @php $exCount++; @endphp
                                                @endforeach
                                            @else
                                            <div class="exercise-row row">
                                                <div class="col-md-3">
                                                    <select name="exercises[0][exercise_name]" class="form-control ex-name-select" data-placeholder="Exercise name">
                                                        <option value=""></option>
                                                        @foreach($exerciseNames as $exName)
                                                            <option value="{{ $exName }}">{{ $exName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="exercises[0][sets]" class="form-control" placeholder="Sets">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="exercises[0][repetitions]" class="form-control" placeholder="Reps">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="exercises[0][frequency]" class="form-control" placeholder="Frequency">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="exercises[0][duration]" class="form-control" placeholder="Duration">
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="exercises[0][category]" class="form-control ex-category-select" data-placeholder="Category">
                                                        <option value=""></option>
                                                        @foreach($exerciseCategories as $cat)
                                                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-exercise"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                                @php $exCount = 1; @endphp
                                            @endif
                                        </div>
                                        <button type="button" id="add-exercise" class="btn btn-sm btn-success mt-2"><i class="fa fa-plus"></i> Add Exercise</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Assessment</button>
                            <a href="{{ route('assessments.show', $assessment->id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                        {{ Html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('page-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(function() {
    $('.section-card .card-header').click(function() {
        $(this).closest('.section-card').toggleClass('collapsed');
    });

    function initAddIfNotFound($el, type) {
        $el.select2({
            width: '100%',
            tags: true,
            placeholder: $el.data('placeholder') || 'Select',
            createTag: function(params) {
                return { id: params.term, text: params.term, isNew: true };
            }
        });

        $el.on('select2:select', function(e) {
            var data = e.params.data;
            if (!data.isNew) return;

            if (!confirm('"' + data.text + '" not found. Add to master list?')) {
                $el.val('').trigger('change');
                return;
            }

            $.post('{{ route('dropdown-options.quick') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                name: data.text
            }).done(function(res) {
                $el.val(res.name).trigger('change');
            }).fail(function() {
                alert('Could not add value.');
                $el.val('').trigger('change');
            });
        });
    }

    function initTagsMergedTextarea($select, $textarea, type) {
        $select.select2({
            width: '100%',
            multiple: true,
            tags: true,
            placeholder: $select.data('placeholder') || 'Select or type...',
            tokenSeparators: [',', '\n']
        });

        function syncTextarea() {
            var vals = $select.val() || [];
            $textarea.val(vals.join('\n'));
        }

        var existing = $textarea.val() ? $textarea.val().split(/[\n,]+/).map(function(s) { return $.trim(s); }).filter(Boolean) : [];
        $select.val(existing).trigger('change');

        $select.on('select2:select', function(e) {
            var data = e.params.data;

            if (!data.isNew) {
                syncTextarea();
                return;
            }

            var raw = data.text;
            if (!confirm('"' + raw + '" not found. Add to master list?')) {
                var cur = $select.val() || [];
                $select.val(cur.filter(function(v) { return v !== raw; })).trigger('change');
                syncTextarea();
                return;
            }

            $.post('{{ route('dropdown-options.quick') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                name: raw
            }).done(function(res) {
                var cur = $select.val() || [];
                var idx = cur.lastIndexOf(raw);
                if (idx !== -1) cur[idx] = res.name;
                $select.val(cur).trigger('change');
                syncTextarea();
            }).fail(function() {
                var cur = $select.val() || [];
                $select.val(cur.filter(function(v) { return v !== raw; })).trigger('change');
                syncTextarea();
                alert('Could not add value.');
            });
        });

        $select.on('select2:unselect', syncTextarea);
    }

    initAddIfNotFound($('.inv-type-select'), 'investigation_type');
    initAddIfNotFound($('.ex-name-select'), 'exercise_name');
    initAddIfNotFound($('.ex-category-select'), 'exercise_category');

    initAddIfNotFound($('.ci-type-select'), 'clinical_impression');
    initAddIfNotFound($('.precaution-type-select'), 'precaution');
    initAddIfNotFound($('.advice-type-select'), 'advice');

    var ccIndex = {{ max(count($ccLines ?? []), 1) }};
    $('#add-complaint').click(function() {
        var html = '<div class="complaint-row row">' +
            '<div class="col-md-11"><select name="complaints[' + ccIndex + '][complaint]" class="form-control cc-type-select" data-placeholder="Chief complaint...">' +
            '<option value=""></option>@foreach($complaints as $c)<option value="{{ $c }}">{{ $c }}</option>@endforeach</select></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-complaint"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#complaints-container').append(html);
        initAddIfNotFound($('#complaints-container .complaint-row:last .cc-type-select'), 'complaint');
        ccIndex++;
    });

    $(document).on('click', '.remove-complaint', function() {
        $(this).closest('.complaint-row').remove();
    });

    var stIndex = {{ max(count($stLines ?? []), 1) }};
    $('#add-special-test').click(function() {
        var html = '<div class="special-test-row row mb-1">' +
            '<div class="col-md-11"><select name="specialTests[' + stIndex + '][test]" class="form-control st-type-select" data-placeholder="Special test...">' +
            '<option value=""></option>@foreach($specialTests as $st)<option value="{{ $st }}">{{ $st }}</option>@endforeach</select></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-special-test"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#special-tests-container').append(html);
        initAddIfNotFound($('#special-tests-container .special-test-row:last .st-type-select'), 'special_test');
        stIndex++;
    });

    $(document).on('click', '.remove-special-test', function() {
        $(this).closest('.special-test-row').remove();
    });

    var ciIndex = {{ max(count($ciLines ?? []), 1) }};
    $('#add-clinical-impression').click(function() {
        var html = '<div class="clinical-impression-row row mb-1">' +
            '<div class="col-md-11"><select name="clinicalImpressions[' + ciIndex + '][impression]" class="form-control ci-type-select" data-placeholder="Clinical impression...">' +
            '<option value=""></option>@foreach($clinicalImpressions as $ci)<option value="{{ $ci }}">{{ $ci }}</option>@endforeach</select></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-clinical-impression"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#clinical-impressions-container').append(html);
        initAddIfNotFound($('#clinical-impressions-container .clinical-impression-row:last .ci-type-select'), 'clinical_impression');
        ciIndex++;
    });

    $(document).on('click', '.remove-clinical-impression', function() {
        $(this).closest('.clinical-impression-row').remove();
    });

    var precautionIndex = {{ max(count($pLines ?? []), 1) }};
    $('#add-precaution').click(function() {
        var html = '<div class="precaution-row row mb-1">' +
            '<div class="col-md-11"><select name="precautionList[' + precautionIndex + '][precaution]" class="form-control precaution-type-select" data-placeholder="Precaution...">' +
            '<option value=""></option>@foreach($precautions as $p)<option value="{{ $p }}">{{ $p }}</option>@endforeach</select></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-precaution"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#precautions-container').append(html);
        initAddIfNotFound($('#precautions-container .precaution-row:last .precaution-type-select'), 'precaution');
        precautionIndex++;
    });

    $(document).on('click', '.remove-precaution', function() {
        $(this).closest('.precaution-row').remove();
    });

    var adviceIndex = {{ max(count($aLines ?? []), 1) }};
    $('#add-advice').click(function() {
        var html = '<div class="advice-row row mb-1">' +
            '<div class="col-md-11"><select name="adviceList[' + adviceIndex + '][advice]" class="form-control advice-type-select" data-placeholder="Advice...">' +
            '<option value=""></option>@foreach($advices as $a)<option value="{{ $a }}">{{ $a }}</option>@endforeach</select></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-advice"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#advices-container').append(html);
        initAddIfNotFound($('#advices-container .advice-row:last .advice-type-select'), 'advice');
        adviceIndex++;
    });

    $(document).on('click', '.remove-advice', function() {
        $(this).closest('.advice-row').remove();
    });

    var invIndex = {{ max($assessment->investigations->count(), 1) }};
    $('#add-investigation').click(function() {
        var html = '<div class="investigation-row row">' +
            '<div class="col-md-3"><select name="investigations[' + invIndex + '][type]" class="form-control inv-type-select" data-placeholder="Type">' +
            '<option value=""></option>@foreach($investigationTypes as $invType)<option value="{{ $invType }}">{{ $invType }}</option>@endforeach</select></div>' +
            '<div class="col-md-2"><input type="date" name="investigations[' + invIndex + '][date]" class="form-control"></div>' +
            '<div class="col-md-4"><input type="text" name="investigations[' + invIndex + '][findings]" class="form-control" placeholder="Findings"></div>' +
            '<div class="col-md-2"><input type="text" name="investigations[' + invIndex + '][facility]" class="form-control" placeholder="Facility"></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-investigation"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#investigations-container').append(html);
        initAddIfNotFound($('#investigations-container .investigation-row:last .inv-type-select'), 'investigation_type');
        invIndex++;
    });

    $(document).on('click', '.remove-investigation', function() {
        $(this).closest('.investigation-row').remove();
    });

    var exIndex = {{ $exCount }};
    $('#add-exercise').click(function() {
        var html = '<div class="exercise-row row">' +
            '<div class="col-md-3"><select name="exercises[' + exIndex + '][exercise_name]" class="form-control ex-name-select" data-placeholder="Exercise name">' +
            '<option value=""></option>@foreach($exerciseNames as $exName)<option value="{{ $exName }}">{{ $exName }}</option>@endforeach</select></div>' +
            '<div class="col-md-2"><input type="text" name="exercises[' + exIndex + '][sets]" class="form-control" placeholder="Sets"></div>' +
            '<div class="col-md-1"><input type="text" name="exercises[' + exIndex + '][repetitions]" class="form-control" placeholder="Reps"></div>' +
            '<div class="col-md-2"><input type="text" name="exercises[' + exIndex + '][frequency]" class="form-control" placeholder="Frequency"></div>' +
            '<div class="col-md-1"><input type="text" name="exercises[' + exIndex + '][duration]" class="form-control" placeholder="Duration"></div>' +
            '<div class="col-md-2"><select name="exercises[' + exIndex + '][category]" class="form-control ex-category-select" data-placeholder="Category">' +
            '<option value=""></option>@foreach($exerciseCategories as $cat)<option value="{{ $cat }}">{{ ucfirst($cat) }}</option>@endforeach</select></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-exercise"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#exercises-container').append(html);
        initAddIfNotFound($('#exercises-container .exercise-row:last .ex-name-select'), 'exercise_name');
        initAddIfNotFound($('#exercises-container .exercise-row:last .ex-category-select'), 'exercise_category');
        exIndex++;
    });

    $(document).on('click', '.remove-exercise', function() {
        $(this).closest('.exercise-row').remove();
    });
});
</script>
@endsection
