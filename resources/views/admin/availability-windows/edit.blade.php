@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Edit Availability Window</h1>
</div>

<div class="col-sm-6">
<a href="{{ route('admin.availability-windows.index') }}" class="btn btn-default">
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
    <h3 class="card-title">Availability Window Details</h3>
</div>

<form method="POST" action="{{ route('admin.availability-windows.update', $availabilityWindow->id) }}">
@csrf
@method('PUT')

<div class="card-body">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="branch_id">Branch *</label>
            <select class="form-control @error('branch_id') is-invalid @enderrorror" 
                    id="branch_id" name="branch_id" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ old('branch_id', $availabilityWindow->branch_id) == $branch->id ? 'selected' : '' }}>
                    {{ $branch->branchName }}
                </option>
                @endforeach
            </select>
            @error('branch_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderrorror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="appointment_type_id">Appointment Type *</label>
            <select class="form-control @error('appointment_type_id') is-invalid @enderror" 
                    id="appointment_type_id" name="appointment_type_id" required>
                <option value="">Select Type</option>
                @foreach($appointmentTypes as $type)
                <option value="{{ $type->id }}" {{ old('appointment_type_id', $availabilityWindow->appointment_type_id) == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
                @endforeach
            </select>
            @error('appointment_type_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderrorror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="day_of_week">Day of Week *</label>
            <select class="form-control @error('day_of_week') is-invalid @enderror" 
                    id="day_of_week" name="day_of_week" required>
                <option value="">Select Day</option>
                @foreach($days as $index => $day)
                <option value="{{ $index }}" {{ old('day_of_week', $availabilityWindow->day_of_week) == $index ? 'selected' : '' }}>
                    {{ $day }}
                </option>
                @endforeach
            </select>
            @error('day_of_week')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderrorror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="is_active">Status</label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1" {{ old('is_active', $availabilityWindow->is_active) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', $availabilityWindow->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="start_time">Start Time *</label>
            <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                   id="start_time" name="start_time" value="{{ old('start_time', $availabilityWindow->start_time) }}" required>
            @error('start_time')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderrorror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="end_time">End Time *</label>
            <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                   id="end_time" name="end_time" value="{{ old('end_time', $availabilityWindow->end_time) }}" required>
            @error('end_time')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderrorror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="slot_duration">Slot Duration (min) *</label>
            <input type="number" class="form-control @error('slot_duration') is-invalid @enderror" 
                   id="slot_duration" name="slot_duration" value="{{ old('slot_duration', $availabilityWindow->slot_duration) }}" required min="1">
            @error('slot_duration')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderrorror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="capacity">Capacity *</label>
            <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                   id="capacity" name="capacity" value="{{ old('capacity', $availabilityWindow->capacity) }}" required min="1">
            @error('capacity')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderrorror
        </div>
    </div>
</div>

</div>

<div class="card-footer">
<button type="submit" class="btn btn-warning">Update</button>
<a href="{{ route('admin.availability-windows.index') }}" class="btn btn-default">Cancel</a>
</div>

</form>

</div>

</div>
</section>

</div>

@endsection