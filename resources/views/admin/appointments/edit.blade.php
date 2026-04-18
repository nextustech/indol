@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Edit Appointment</h1>
</div>

<div class="col-sm-6">
<a href="{{ route('admin.appointments.index') }}" class="btn btn-default">
    <i class="fas fa-arrow-left"></i> Back to List
</a>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card card-warning">
<div class="card-header">
    <h3 class="card-title">Appointment Details</h3>
</div>

<form method="POST" action="{{ route('admin.appointments.update', $appointment->id) }}">
@csrf
@method('PUT')

<div class="card-body">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="patient_name">Patient Name *</label>
            <input type="text" class="form-control @error('patient_name') is-invalid @enderror" 
                   id="patient_name" name="patient_name" value="{{ old('patient_name', $appointment->patient_name) }}" required>
            @error('patient_name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                   id="phone" name="phone" value="{{ old('phone', $appointment->phone) }}" required>
            @error('phone')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', $appointment->email) }}">
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="consultation_topic">Consultation Topic</label>
            <input type="text" class="form-control @error('consultation_topic') is-invalid @enderror" 
                   id="consultation_topic" name="consultation_topic" value="{{ old('consultation_topic', $appointment->consultation_topic) }}">
            @error('consultation_topic')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="branch_id">Branch *</label>
            <select class="form-control @error('branch_id') is-invalid @enderror" 
                    id="branch_id" name="branch_id" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ old('branch_id', $appointment->branch_id) == $branch->id ? 'selected' : '' }}>
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
            <label for="appointment_type_id">Appointment Type *</label>
            <select class="form-control @error('appointment_type_id') is-invalid @enderror" 
                    id="appointment_type_id" name="appointment_type_id" required>
                <option value="">Select Type</option>
                @foreach($appointmentTypes as $type)
                <option value="{{ $type->id }}" {{ old('appointment_type_id', $appointment->appointment_type_id) == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
                @endforeach
            </select>
            @error('appointment_type_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="appointment_date">Date *</label>
            <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" 
                   id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" required>
            @error('appointment_date')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="start_time">Start Time *</label>
            <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                   id="start_time" name="start_time" value="{{ old('start_time', $appointment->start_time) }}" required>
            @error('start_time')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="end_time">End Time *</label>
            <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                   id="end_time" name="end_time" value="{{ old('end_time', $appointment->end_time) }}" required>
            @error('end_time')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="status">Status *</label>
            <select class="form-control @error('status') is-invalid @enderror" 
                    id="status" name="status" required>
                <option value="booked" {{ old('status', $appointment->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

</div>

<div class="card-footer">
<button type="submit" class="btn btn-warning">Update Appointment</button>
<a href="{{ route('admin.appointments.index') }}" class="btn btn-default">Cancel</a>
</div>

</form>

</div>

</div>
</section>

</div>

@endsection