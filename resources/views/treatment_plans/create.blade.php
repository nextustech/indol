@extends('layouts.backend')
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success card-outline">
                        <div class="card-header"><h5 class="m-0">Create Treatment Plan</h5></div>
                        {{ Html()->form('POST')->route('treatment-plans.store')->open() }}
                        <div class="card-body">
                            @include('errors.list')

                            @if($assessment)
                            <div class="alert alert-info">
                                <strong>Patient:</strong> {{ $assessment->patient->name ?? 'N/A' }} |
                                <strong>Date:</strong> {{ $assessment->assessment_date->format('d M Y') }}
                                <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                <input type="hidden" name="patient_id" value="{{ $assessment->patient_id }}">
                            </div>
                            @else
                            <div class="form-group">
                                <label>Assessment <span class="text-danger">*</span></label>
                                <select name="assessment_id" class="form-control" required>
                                    <option value="">Select Assessment</option>
                                </select>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Short-term Goals</label>
                                    <textarea name="short_term_goals" class="form-control" rows="3">{{ old('short_term_goals') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Long-term Goals</label>
                                    <textarea name="long_term_goals" class="form-control" rows="3">{{ old('long_term_goals') }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label>Precautions / Avoid</label>
                                    <textarea name="precautions" class="form-control" rows="3">{{ old('precautions') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Advice</label>
                                    <textarea name="advice" class="form-control" rows="3">{{ old('advice') }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label>Follow-up Instructions</label>
                                    <textarea name="follow_up_instructions" class="form-control" rows="2">{{ old('follow_up_instructions') }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="completed">Completed</option>
                                        <option value="discontinued">Discontinued</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Plan</button>
                            <a href="{{ route('assessments.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                        {{ Html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
