@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Availability Window #{{ $availabilityWindow->id }}</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.availability-windows.index') }}" class="btn btn-default">
    <i class="fas fa-arrow-left"></i> Back
</a>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="row">
<div class="col-md-6">
<div class="card">
<div class="card-header">
    <h3 class="card-title">Details</h3>
</div>
<div class="card-body">
    <table class="table table-borderless">
        <tr>
            <th>Branch:</th>
            <td>{{ $availabilityWindow->branch->branchName ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Appointment Type:</th>
            <td>{{ $availabilityWindow->appointmentType->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Day:</th>
            <td>{{ $days[$availabilityWindow->day_of_week] }}</td>
        </tr>
        <tr>
            <th>Time:</th>
            <td>{{ \Carbon\Carbon::parse($availabilityWindow->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($availabilityWindow->end_time)->format('h:i A') }}</td>
        </tr>
        <tr>
            <th>Slot Duration:</th>
            <td>{{ $availabilityWindow->slot_duration }} minutes</td>
        </tr>
        <tr>
            <th>Capacity:</th>
            <td>{{ $availabilityWindow->capacity }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>
                @if($availabilityWindow->is_active)
                <span class="badge badge-success">Active</span>
                @else
                <span class="badge badge-danger">Inactive</span>
                @endif
            </td>
        </tr>
    </table>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card">
<div class="card-header">
    <h3 class="card-title">Actions</h3>
</div>
<div class="card-body">
    <a href="{{ route('admin.availability-windows.edit', $availabilityWindow->id) }}" class="btn btn-warning btn-block">
        <i class="fas fa-edit"></i> Edit
    </a>
    <form method="POST" action="{{ route('admin.availability-windows.destroy', $availabilityWindow->id) }}">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-block" onclick="return confirm('Delete this window?')">
            <i class="fas fa-trash"></i> Delete
        </button>
    </form>
</div>
</div>
</div>
</div>

</div>
</section>

</div>

@endsection