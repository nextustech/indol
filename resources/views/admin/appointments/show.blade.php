@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Appointment Details</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.appointments.index') }}" class="btn btn-default">
    <i class="fas fa-arrow-left"></i> Back to List
</a>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="row">

<div class="col-md-8">

<div class="card">
<div class="card-header">
    <h3 class="card-title">
        <strong>Patient:</strong> {{ $appointment->patient_name }}
    </h3>
    <div class="card-tools">
        @switch($appointment->status)
            @case('booked')
                <span class="badge badge-primary">Booked</span>
                @break
            @case('completed')
                <span class="badge badge-success">Completed</span>
                @break
            @case('cancelled')
                <span class="badge badge-danger">Cancelled</span>
                @break
        @endswitch
    </div>
</div>
<div class="card-body">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Consultation Topic:</label>
            <p>{{ $appointment->consultation_topic ?? 'N/A' }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Branch:</label>
            <p>{{ $appointment->branch->branchName ?? 'N/A' }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Appointment Type:</label>
            <p>{{ $appointment->appointmentType->name ?? 'N/A' }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Date:</label>
            <p>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Time:</label>
            <p>{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Created At:</label>
            <p>{{ $appointment->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </div>
</div>

</div>
</div>

</div>

<div class="col-md-4">

<div class="card">
<div class="card-header">
    <h3 class="card-title">Contact Information</h3>
</div>
<div class="card-body">

<div class="form-group">
    <label>Phone:</label>
    <p>
        <a href="tel:{{ $appointment->phone }}">{{ $appointment->phone }}</a>
    </p>
</div>

<div class="form-group">
    <label>Email:</label>
    <p>
        @if($appointment->email)
        <a href="mailto:{{ $appointment->email }}">{{ $appointment->email }}</a>
        @else
        N/A
        @endif
    </p>
</div>

<div class="form-group">
    <label>Actions:</label>
    <div class="btn-group-vertical w-100">
        <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form method="POST" action="{{ route('admin.appointments.destroy', $appointment->id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-block" onclick="return confirm('Delete this appointment?')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
    </div>
</div>

</div>
</div>

<div class="card mt-3">
<div class="card-header">
    <h3 class="card-title">Update Status</h3>
</div>
<div class="card-body">
    <form method="POST" action="{{ route('admin.appointments.updateStatus', $appointment->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <select name="status" class="form-control">
                <option value="booked" {{ $appointment->status == 'booked' ? 'selected' : '' }}>Booked</option>
                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Update Status</button>
    </form>
</div>
</div>

</div>

</div>

</div>
</section>

</div>

@endsection