@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Branch Appointment Types</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.branch-appointment-types.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Add Assignment
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

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
<div class="card-header">
    <form method="GET" action="{{ route('admin.branch-appointment-types.index') }}" class="form-inline">
        <div class="input-group">
            <select name="branch_id" class="form-control" onchange="this.form.submit()">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->branchName }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group ml-2">
            <select name="appointment_type_id" class="form-control" onchange="this.form.submit()">
                <option value="">All Types</option>
                @foreach($appointmentTypes as $type)
                <option value="{{ $type->id }}" {{ request('appointment_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<div class="card-body table-responsive">

<table class="table table-bordered table-striped">

<thead>
<tr>
    <th>ID</th>
    <th>Branch</th>
    <th>Appointment Type</th>
    <th>Type Duration</th>
    <th>Type Price</th>
    <th width="120">Action</th>
</tr>
</thead>

<tbody>

@forelse($branchTypes as $bat)

<tr>
    <td>{{ $bat->id }}</td>
    <td><strong>{{ $bat->branch->branchName ?? '-' }}</strong></td>
    <td>{{ $bat->appointmentType->name ?? '-' }}</td>
    <td>{{ $bat->appointmentType->duration ?? '-' }} min</td>
    <td>{{ $bat->appointmentType->price ? '₹' . number_format($bat->appointmentType->price, 2) : '-' }}</td>
    <td>
        <a href="{{ route('admin.branch-appointment-types.show', $bat->id) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.branch-appointment-types.edit', $bat->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i>
        </a>
        <form method="POST" action="{{ route('admin.branch-appointment-types.destroy', $bat->id) }}" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this assignment?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
</tr>

@empty

<tr>
    <td colspan="6" class="text-center">No branch appointment types found.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="card-footer">
{{ $branchTypes->links() }}
</div>

</div>

</div>
</section>

</div>

@endsection