@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Branch Appointment Type Details</h1>
</div>

<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('admin.branch-appointment-types.index') }}">Branch Appointment Types</a></li>
    <li class="breadcrumb-item active">View</li>
</ol>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<table class="table table-bordered">

<tr>
    <th width="200">ID</th>
    <td>{{ $branchType->id }}</td>
</tr>

<tr>
    <th>Branch</th>
    <td>{{ $branchType->branch->branchName ?? '-' }}</td>
</tr>

<tr>
    <th>Appointment Type</th>
    <td>{{ $branchType->appointmentType->name ?? '-' }}</td>
</tr>

<tr>
    <th>Type Duration</th>
    <td>{{ $branchType->appointmentType->duration ?? '-' }} minutes</td>
</tr>

<tr>
    <th>Type Price</th>
    <td>{{ $branchType->appointmentType->price ? '₹' . number_format($branchType->appointmentType->price, 2) : '-' }}</td>
</tr>

<tr>
    <th>Type Status</th>
    <td>
        @if($branchType->appointmentType->is_active)
        <span class="badge badge-success">Active</span>
        @else
        <span class="badge badge-danger">Inactive</span>
        @endif
    </td>
</tr>

</table>

</div>

<div class="card-footer">
    <a href="{{ route('admin.branch-appointment-types.edit', $branchType->id) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> Edit
    </a>
    <a href="{{ route('admin.branch-appointment-types.index') }}" class="btn btn-default">
        Back
    </a>
</div>

</div>

</div>
</section>

</div>

@endsection