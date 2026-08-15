@extends('layouts.backend')
@section('page-css')
<style>
    .report-section { margin-bottom: 1rem; }
    .report-section .card-header { padding: .5rem 1rem; font-weight: 600; }
    .field-label { font-weight: 600; color: #495057; font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; }
    .field-value { white-space: pre-wrap; padding: .5rem 0; }
    .badge-status { font-size: .8rem; padding: .3rem .6rem; }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('errors.list')
                    @if (Session::has('message'))
                        <div class="alert alert-success text-center">{{ session('message') }}</div>
                    @endif

                    <div class="card card-primary card-outline">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="m-0">Physiotherapy Assessment Report</h5>
                            <div>
                                @can('edit-Assessment')
                                <a href="{{ route('assessments.edit', $assessment->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pen"></i> Edit</a>
                                @endcan
                                @can('print-Assessment')
                                <a href="{{ route('assessmentPrint', $assessment->id) }}" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-print"></i> Print</a>
                                @endcan
                                @can('delete-Assessment')
                                {{ Html()->form('DELETE')->route('assessments.destroy', $assessment->id)->open() }}
                                <button type="submit" class="btn btn-danger btn-sm" onclick='return confirm("Are you sure?")'><i class="fa fa-trash"></i> Delete</button>
                                {{ Html()->form()->close() }}
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- Patient Info Header --}}
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <h4>{{ $assessment->patient->name ?? 'N/A' }}</h4>
                                    <p class="mb-1">
                                        <strong>Patient ID:</strong> {{ $assessment->patient->patientId ?? 'N/A' }} |
                                        <strong>Age/Sex:</strong> {{ $assessment->patient->age ?? 'N/A' }}/{{ $assessment->patient->gender ?? 'N/A' }} |
                                        <strong>Mobile:</strong> {{ $assessment->patient->mobile ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <span class="badge badge-status {{ $assessment->status == 'completed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($assessment->status) }}
                                    </span>
                                    <span class="badge badge-info badge-status">{{ ucfirst($assessment->type) }}</span>
                                    <p class="mt-2 mb-0"><strong>Date:</strong> {{ $assessment->assessment_date->format('d M Y, h:i A') }}</p>
                                    <p class="mb-0"><strong>Assessed by:</strong> {{ $assessment->assessedBy->name ?? 'N/A' }}</p>
                                    <p class="mb-0"><strong>Branch:</strong> {{ $assessment->branch->branchName ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <hr>

                            {{-- Chief Complaints --}}
                            @if($assessment->chief_complaints)
                            <div class="report-section">
                                <div class="card-header bg-secondary">Chief Complaints</div>
                                <div class="card-body"><div class="field-value">{{ $assessment->chief_complaints }}</div></div>
                            </div>
                            @endif

                            {{-- History --}}
                            @if($assessment->history_of_present_illness)
                            <div class="report-section">
                                <div class="card-header bg-secondary">History of Present Illness</div>
                                <div class="card-body"><div class="field-value">{{ $assessment->history_of_present_illness }}</div></div>
                            </div>
                            @endif

                            {{-- Objective Examination --}}
                            @if($assessment->observation || $assessment->palpation || $assessment->range_of_motion || $assessment->muscle_strength || $assessment->special_tests || $assessment->neurological || $assessment->postural_assessment || $assessment->clinical_impression)
                            <div class="report-section">
                                <div class="card-header bg-secondary">Objective Examination</div>
                                <div class="card-body">
                                    <div class="row">
                                        @if($assessment->observation)
                                        <div class="col-md-6">
                                            <div class="field-label">Observation</div>
                                            <div class="field-value">{{ $assessment->observation }}</div>
                                        </div>
                                        @endif
                                        @if($assessment->palpation)
                                        <div class="col-md-6">
                                            <div class="field-label">Palpation</div>
                                            <div class="field-value">{{ $assessment->palpation }}</div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row mt-2">
                                        @if($assessment->range_of_motion)
                                        <div class="col-md-6">
                                            <div class="field-label">Range of Motion</div>
                                            <div class="field-value">{{ $assessment->range_of_motion }}</div>
                                        </div>
                                        @endif
                                        @if($assessment->muscle_strength)
                                        <div class="col-md-6">
                                            <div class="field-label">Muscle Strength</div>
                                            <div class="field-value">{{ $assessment->muscle_strength }}</div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row mt-2">
                                        @if($assessment->special_tests)
                                        <div class="col-md-6">
                                            <div class="field-label">Special Tests</div>
                                            <div class="field-value">{{ $assessment->special_tests }}</div>
                                        </div>
                                        @endif
                                        @if($assessment->neurological)
                                        <div class="col-md-6">
                                            <div class="field-label">Neurological</div>
                                            <div class="field-value">{{ $assessment->neurological }}</div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row mt-2">
                                        @if($assessment->postural_assessment)
                                        <div class="col-md-6">
                                            <div class="field-label">Postural Assessment</div>
                                            <div class="field-value">{{ $assessment->postural_assessment }}</div>
                                        </div>
                                        @endif
                                        @if($assessment->clinical_impression)
                                        <div class="col-md-6">
                                            <div class="field-label">Clinical Impression</div>
                                            <div class="field-value">{{ $assessment->clinical_impression }}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Investigations --}}
                            @if($assessment->investigations->count() > 0)
                            <div class="report-section">
                                <div class="card-header bg-secondary">Investigations</div>
                                <div class="card-body p-0">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Findings</th>
                                                <th>Facility</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($assessment->investigations as $inv)
                                            <tr>
                                                <td>{{ $inv->type }}</td>
                                                <td>{{ $inv->investigation_date ? $inv->investigation_date->format('d M Y') : 'N/A' }}</td>
                                                <td>{{ $inv->findings ?? 'N/A' }}</td>
                                                <td>{{ $inv->facility ?? 'N/A' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            {{-- Treatment Plan --}}
                            @if($assessment->treatmentPlan)
                            @php $plan = $assessment->treatmentPlan; @endphp
                            <div class="report-section">
                                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                    <span>Treatment Plan</span>
                                    @can('edit-TreatmentPlan')
                                    <a href="{{ route('treatment-plans.edit', $plan->id) }}" class="btn btn-sm btn-light">
                                        <i class="fa fa-pen"></i> Edit Plan
                                    </a>
                                    @endcan
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if($plan->short_term_goals)
                                        <div class="col-md-6">
                                            <div class="field-label">Short-term Goals</div>
                                            <div class="field-value">{{ $plan->short_term_goals }}</div>
                                        </div>
                                        @endif
                                        @if($plan->long_term_goals)
                                        <div class="col-md-6">
                                            <div class="field-label">Long-term Goals</div>
                                            <div class="field-value">{{ $plan->long_term_goals }}</div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row mt-2">
                                        @if($plan->precautions)
                                        <div class="col-md-6">
                                            <div class="field-label text-danger">Precautions / Avoid</div>
                                            <div class="field-value">{{ $plan->precautions }}</div>
                                        </div>
                                        @endif
                                        @if($plan->advice)
                                        <div class="col-md-6">
                                            <div class="field-label text-success">Advice</div>
                                            <div class="field-value">{{ $plan->advice }}</div>
                                        </div>
                                        @endif
                                    </div>
                                    @if($plan->follow_up_instructions)
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="field-label">Follow-up Instructions</div>
                                            <div class="field-value">{{ $plan->follow_up_instructions }}</div>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Exercises --}}
                                    @if($plan->exercises->count() > 0)
                                    <hr>
                                    <h6>Exercise Prescription</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Exercise</th>
                                                    <th>Category</th>
                                                    <th>Sets</th>
                                                    <th>Reps</th>
                                                    <th>Frequency</th>
                                                    <th>Duration</th>
                                                    <th>Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($plan->exercises as $ex)
                                                <tr>
                                                    <td><strong>{{ $ex->exercise_name }}</strong></td>
                                                    <td>{{ ucfirst($ex->category) }}</td>
                                                    <td>{{ $ex->sets ?? '-' }}</td>
                                                    <td>{{ $ex->repetitions ?? '-' }}</td>
                                                    <td>{{ $ex->frequency ?? '-' }}</td>
                                                    <td>{{ $ex->duration ?? '-' }}</td>
                                                    <td>{{ $ex->notes ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="report-section">
                                <div class="card-header bg-secondary">Treatment Plan</div>
                                <div class="card-body text-center">
                                    <p class="text-muted">No treatment plan created yet.</p>
                                    @can('create-TreatmentPlan')
                                    <a href="{{ route('treatment-plans.create', ['assessment_id' => $assessment->id]) }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i> Create Treatment Plan
                                    </a>
                                    @endcan
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
