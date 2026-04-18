@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Edit Holiday</h1>
</div>

<div class="col-sm-6">
<a href="{{ route('admin.holidays.index') }}" class="btn btn-default">
    <i class="fas fa-arrow-left"></i> Back
</a>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card card-warning">
<div class="card-header">
    <h3 class="card-title">Holiday Details</h3>
</div>

<form method="POST" action="{{ route('admin.holidays.update', $holiday->id) }}">
@csrf
@method('PUT')

<div class="card-body">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="branch_id">Branch *</label>
            <select class="form-control @error('branch_id') is-invalid @enderror" 
                    id="branch_id" name="branch_id" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ old('branch_id', $holiday->branch_id) == $branch->id ? 'selected' : '' }}>
                    {{ $branch->branchName }}
                </option>
                @endforeach
            </select>
            @error('branch_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Holiday Name *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', $holiday->name) }}" required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="start_date">Start Date *</label>
            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                   id="start_date" name="start_date" value="{{ old('start_date', $holiday->start_date) }}" required>
            @error('start_date')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                   id="end_date" name="end_date" value="{{ old('end_date', $holiday->end_date) }}">
            @error('end_date')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row" id="partial-time" style="display: {{ $holiday->is_full_day ? 'none' : 'block' }};">
    <div class="col-md-6">
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', $holiday->start_time) }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', $holiday->end_time) }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is_full_day" name="is_full_day" value="1" {{ old('is_full_day', $holiday->is_full_day) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_full_day">Full Day Holiday</label>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is_recurring" name="is_recurring" value="1" {{ old('is_recurring', $holiday->is_recurring) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_recurring">Recurring Yearly</label>
            </div>
        </div>
    </div>
</div>

</div>

<div class="card-footer">
<button type="submit" class="btn btn-warning">Update</button>
<a href="{{ route('admin.holidays.index') }}" class="btn btn-default">Cancel</a>
</div>

</form>

</div>

</div>
</section>

</div>

@push('scripts')
<script>
$('#is_full_day').change(function() {
    if($(this).is(':checked')) {
        $('#partial-time').hide();
    } else {
        $('#partial-time').show();
    }
});
</script>
@endpush

@endsection