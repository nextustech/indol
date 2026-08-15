@extends('layouts.backend')
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Treatment Plan — {{ $treatmentPlan->patient->name ?? 'N/A' }}</h5>
                            <div class="card-tools">
                                @can('edit-TreatmentPlan')
                                <a href="{{ route('treatment-plans.edit', $treatmentPlan->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pen"></i> Edit</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if($treatmentPlan->short_term_goals)
                                <div class="col-md-6">
                                    <h6>Short-term Goals</h6>
                                    <p>{{ $treatmentPlan->short_term_goals }}</p>
                                </div>
                                @endif
                                @if($treatmentPlan->long_term_goals)
                                <div class="col-md-6">
                                    <h6>Long-term Goals</h6>
                                    <p>{{ $treatmentPlan->long_term_goals }}</p>
                                </div>
                                @endif
                            </div>
                            <div class="row mt-3">
                                @if($treatmentPlan->precautions)
                                <div class="col-md-6">
                                    <h6 class="text-danger">Precautions / Avoid</h6>
                                    <p>{{ $treatmentPlan->precautions }}</p>
                                </div>
                                @endif
                                @if($treatmentPlan->advice)
                                <div class="col-md-6">
                                    <h6 class="text-success">Advice</h6>
                                    <p>{{ $treatmentPlan->advice }}</p>
                                </div>
                                @endif
                            </div>
                            @if($treatmentPlan->follow_up_instructions)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h6>Follow-up Instructions</h6>
                                    <p>{{ $treatmentPlan->follow_up_instructions }}</p>
                                </div>
                            </div>
                            @endif

                            @if($treatmentPlan->exercises->count() > 0)
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($treatmentPlan->exercises as $ex)
                                        <tr>
                                            <td>{{ $ex->exercise_name }}</td>
                                            <td>{{ ucfirst($ex->category) }}</td>
                                            <td>{{ $ex->sets ?? '-' }}</td>
                                            <td>{{ $ex->repetitions ?? '-' }}</td>
                                            <td>{{ $ex->frequency ?? '-' }}</td>
                                            <td>{{ $ex->duration ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
