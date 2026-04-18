@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Appointment Types</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.appointment-types.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Add Type
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
    <form method="GET" action="{{ route('admin.appointment-types.index') }}" class="form-inline">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
            <span class="input-group-append">
                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
            </span>
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
    <th>Name</th>
    <th>Duration (min)</th>
    <th>Price</th>
    <th>Status</th>
    <th width="120">Action</th>
</tr>
</thead>

<tbody>

@forelse($types as $type)

<tr>
    <td>{{ $type->id }}</td>
    <td><strong>{{ $type->name }}</strong></td>
    <td>{{ $type->duration }}</td>
    <td>{{ $type->price ? '₹' . number_format($type->price, 2) : '-' }}</td>
    <td>
        @if($type->is_active)
        <span class="badge badge-success">Active</span>
        @else
        <span class="badge badge-danger">Inactive</span>
        @endif
    </td>
    <td>
        <a href="{{ route('admin.appointment-types.show', $type->id) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.appointment-types.edit', $type->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i>
        </a>
        <form method="POST" action="{{ route('admin.appointment-types.destroy', $type->id) }}" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this type?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
</tr>

@empty

<tr>
    <td colspan="6" class="text-center">No appointment types found.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="card-footer">
{{ $types->links() }}
</div>

</div>

</div>
</section>

</div>

@endsection