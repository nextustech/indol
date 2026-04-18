@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Appointments</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Add Appointment
</a>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
<div class="card-header">
    <form method="GET" action="{{ route('admin.appointments.index') }}" class="form-inline">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search patient, phone, email..." value="{{ request('search') }}">
            <span class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </span>
        </div>
        <div class="input-group ml-2">
            <select name="branch_id" class="form-control" onchange="this.form.submit()">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->branchName }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="input-group ml-2">
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="input-group ml-2">
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From Date">
        </div>
        <div class="input-group ml-2">
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To Date">
        </div>
        @if(request()->anyFilled(['search', 'branch_id', 'status', 'date_from', 'date_to']))
        <div class="input-group ml-2">
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-default">
                <i class="fas fa-times"></i> Clear
            </a>
        </div>
        @endif
    </form>
</div>

<div class="card-body table-responsive">

<table class="table table-bordered table-striped">

<thead>
<tr>
    <th>ID</th>
    <th>Patient</th>
    <th>Contact</th>
    <th>Branch</th>
    <th>Type</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
    <th width="150">Action</th>
</tr>
</thead>

<tbody>

@forelse($appointments as $appointment)

<tr>
    <td>{{ $appointment->id }}</td>
    <td>
        <strong>{{ $appointment->patient_name }}</strong>
    </td>
    <td>
        <a href="tel:{{ $appointment->phone }}">{{ $appointment->phone }}</a><br>
        @if($appointment->email)
        <small class="text-muted">{{ $appointment->email }}</small>
        @endif
    </td>
    <td>{{ $appointment->branch->branchName ?? 'N/A' }}</td>
    <td>{{ $appointment->appointmentType->name ?? 'N/A' }}</td>
    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
    <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</td>
    <td>
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
            @default
                <span class="badge badge-secondary">{{ $appointment->status }}</span>
        @endswitch
    </td>
    <td>
        <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="btn btn-primary btn-sm" title="View">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
        <form method="POST" action="{{ route('admin.appointments.destroy', $appointment->id) }}" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this appointment?')" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
</tr>

@empty

<tr>
    <td colspan="9" class="text-center">No appointments found.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="card-footer">
{{ $appointments->links() }}
</div>

</div>

</div>
</section>

</div>

@endsection