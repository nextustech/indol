@extends('layouts.backend')
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success card-outline">
                        <div class="card-header"><h5 class="m-0">Edit Treatment Plan</h5></div>
                        {{ Html()->form('PUT')->route('treatment-plans.update', $treatmentPlan->id)->open() }}
                        <div class="card-body">
                            @include('errors.list')

                            <div class="alert alert-info">
                                <strong>Patient:</strong> {{ $treatmentPlan->patient->name ?? 'N/A' }} |
                                <strong>Assessment:</strong> {{ $treatmentPlan->assessment->assessment_date ? $treatmentPlan->assessment->assessment_date->format('d M Y') : 'N/A' }}
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Short-term Goals</label>
                                    <textarea name="short_term_goals" class="form-control" rows="3">{{ $treatmentPlan->short_term_goals }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Long-term Goals</label>
                                    <textarea name="long_term_goals" class="form-control" rows="3">{{ $treatmentPlan->long_term_goals }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label>Precautions / Avoid</label>
                                    <textarea name="precautions" class="form-control" rows="3">{{ $treatmentPlan->precautions }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Advice</label>
                                    <textarea name="advice" class="form-control" rows="3">{{ $treatmentPlan->advice }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label>Follow-up Instructions</label>
                                    <textarea name="follow_up_instructions" class="form-control" rows="2">{{ $treatmentPlan->follow_up_instructions }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active" {{ $treatmentPlan->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="completed" {{ $treatmentPlan->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="discontinued" {{ $treatmentPlan->status == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Exercises --}}
                            <hr>
                            <h6>Exercise Prescription</h6>
                            <div id="exercises-container">
                                @forelse($treatmentPlan->exercises as $i => $ex)
                                <div class="exercise-row row mb-2">
                                    <div class="col-md-3">
                                        <input type="hidden" name="exercises[{{ $i }}][id]" value="{{ $ex->id }}">
                                        <input type="text" name="exercises[{{ $i }}][exercise_name]" class="form-control" value="{{ $ex->exercise_name }}" placeholder="Exercise name">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="exercises[{{ $i }}][sets]" class="form-control" value="{{ $ex->sets }}" placeholder="Sets">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="exercises[{{ $i }}][repetitions]" class="form-control" value="{{ $ex->repetitions }}" placeholder="Reps">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="exercises[{{ $i }}][frequency]" class="form-control" value="{{ $ex->frequency }}" placeholder="Frequency">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="exercises[{{ $i }}][duration]" class="form-control" value="{{ $ex->duration }}" placeholder="Duration">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="exercises[{{ $i }}][category]" class="form-control">
                                            <option value="">Category</option>
                                            @foreach(['stretching','strengthening','mobilization','stabilization','balance','gait','postural','breathing','other'] as $cat)
                                                <option value="{{ $cat }}" {{ $ex->category == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-exercise"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                @empty
                                <div class="exercise-row row mb-2">
                                    <div class="col-md-3">
                                        <input type="text" name="exercises[0][exercise_name]" class="form-control" placeholder="Exercise name">
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
                                        <select name="exercises[0][category]" class="form-control">
                                            <option value="">Category</option>
                                            @foreach(['stretching','strengthening','mobilization','stabilization','balance','gait','postural','breathing','other'] as $cat)
                                                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-exercise"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                            <button type="button" id="add-exercise" class="btn btn-sm btn-success mt-2"><i class="fa fa-plus"></i> Add Exercise</button>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update Plan</button>
                            <a href="{{ route('assessments.show', $treatmentPlan->assessment_id) }}" class="btn btn-secondary">Cancel</a>
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
<script>
$(function() {
    var exIndex = {{ max($treatmentPlan->exercises->count(), 1) }};
    $('#add-exercise').click(function() {
        var html = '<div class="exercise-row row mb-2">' +
            '<div class="col-md-3"><input type="text" name="exercises[' + exIndex + '][exercise_name]" class="form-control" placeholder="Exercise name"></div>' +
            '<div class="col-md-2"><input type="text" name="exercises[' + exIndex + '][sets]" class="form-control" placeholder="Sets"></div>' +
            '<div class="col-md-1"><input type="text" name="exercises[' + exIndex + '][repetitions]" class="form-control" placeholder="Reps"></div>' +
            '<div class="col-md-2"><input type="text" name="exercises[' + exIndex + '][frequency]" class="form-control" placeholder="Frequency"></div>' +
            '<div class="col-md-1"><input type="text" name="exercises[' + exIndex + '][duration]" class="form-control" placeholder="Duration"></div>' +
            '<div class="col-md-2"><select name="exercises[' + exIndex + '][category]" class="form-control">' +
            '<option value="">Category</option>@foreach(["stretching","strengthening","mobilization","stabilization","balance","gait","postural","breathing","other"] as $cat)<option value="{{ $cat }}">{{ ucfirst($cat) }}</option>@endforeach' +
            '</select></div><div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-exercise"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#exercises-container').append(html);
        exIndex++;
    });
    $(document).on('click', '.remove-exercise', function() {
        $(this).closest('.exercise-row').remove();
    });
});
</script>
@endsection
