@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Holidays</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.holidays.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Add Holiday
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
    <form method="GET" action="{{ route('admin.holidays.index') }}" class="form-inline">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
            <span class="input-group-append">
                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
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
    </form>
</div>

<div class="card-body table-responsive">

<table class="table table-bordered table-striped">

<thead>
<tr>
    <th>ID</th>
    <th>Branch</th>
    <th>Name</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Type</th>
    <th width="120">Action</th>
</tr>
</thead>

<tbody>

@forelse($holidays as $holiday)

<tr>
    <td>{{ $holiday->id }}</td>
    <td>{{ $holiday->branch->branchName ?? 'N/A' }}</td>
    <td><strong>{{ $holiday->name }}</strong></td>
    <td>{{ \Carbon\Carbon::parse($holiday->start_date)->format('d M Y') }}</td>
    <td>{{ $holiday->end_date ? \Carbon\Carbon::parse($holiday->end_date)->format('d M Y') : '-' }}</td>
    <td>
        @if($holiday->is_full_day)
        <span class="badge badge-danger">Full Day</span>
        @else
        <span class="badge badge-warning">Partial</span>
        @endif
        @if($holiday->is_recurring)
        <span class="badge badge-info">Recurring</span>
        @endif
    </td>
    <td>
        <a href="{{ route('admin.holidays.show', $holiday->id) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.holidays.edit', $holiday->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i>
        </a>
        <form method="POST" action="{{ route('admin.holidays.destroy', $holiday->id) }}" style="display:inline-block">
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
    <td colspan="7" class="text-center">No holidays found.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="card-footer">
{{ $holidays->links() }}
</div>

</div>

</div>
</section>

</div>

@endsection