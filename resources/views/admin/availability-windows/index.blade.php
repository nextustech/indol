@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Availability Windows</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.availability-windows.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Add Window
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
    <form method="GET" action="{{ route('admin.availability-windows.index') }}" class="form-inline">
        <div class="input-group">
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
            <select name="appointment_type_id" class="form-control" onchange="this.form.submit()">
                <option value="">All Types</option>
                @foreach($appointmentTypes as $type)
                <option value="{{ $type->id }}" {{ request('appointment_type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="input-group ml-2">
            <select name="is_active" class="form-control" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
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
    <th>Type</th>
    <th>Day</th>
    <th>Time</th>
    <th>Duration</th>
    <th>Capacity</th>
    <th>Status</th>
    <th width="120">Action</th>
</tr>
</thead>

<tbody>

@forelse($windows as $window)

<tr>
    <td>{{ $window->id }}</td>
    <td>{{ $window->branch->branchName ?? 'N/A' }}</td>
    <td>{{ $window->appointmentType->name ?? 'N/A' }}</td>
    <td>{{ ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][$window->day_of_week] }}</td>
    <td>{{ \Carbon\Carbon::parse($window->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($window->end_time)->format('h:i A') }}</td>
    <td>{{ $window->slot_duration }} min</td>
    <td>{{ $window->capacity }}</td>
    <td>
        @if($window->is_active)
        <span class="badge badge-success">Active</span>
        @else
        <span class="badge badge-danger">Inactive</span>
        @endif
    </td>
    <td>
        <a href="{{ route('admin.availability-windows.show', $window->id) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.availability-windows.edit', $window->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i>
        </a>
        <form method="POST" action="{{ route('admin.availability-windows.destroy', $window->id) }}" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
</tr>

@empty

<tr>
    <td colspan="9" class="text-center">No availability windows found.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="card-footer">
{{ $windows->links() }}
</div>

</div>

</div>
</section>

</div>

@endsection