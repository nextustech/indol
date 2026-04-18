@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Holiday Details</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.holidays.index') }}" class="btn btn-default">
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
            <td>{{ $holiday->branch->branchName ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Name:</th>
            <td>{{ $holiday->name }}</td>
        </tr>
        <tr>
            <th>Start Date:</th>
            <td>{{ \Carbon\Carbon::parse($holiday->start_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>End Date:</th>
            <td>{{ $holiday->end_date ? \Carbon\Carbon::parse($holiday->end_date)->format('d M Y') : 'Same as start' }}</td>
        </tr>
        @if(!$holiday->is_full_day && $holiday->start_time)
        <tr>
            <th>Time:</th>
            <td>{{ \Carbon\Carbon::parse($holiday->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($holiday->end_time)->format('h:i A') }}</td>
        </tr>
        @endif
        <tr>
            <th>Type:</th>
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
    <a href="{{ route('admin.holidays.edit', $holiday->id) }}" class="btn btn-warning btn-block">
        <i class="fas fa-edit"></i> Edit
    </a>
    <form method="POST" action="{{ route('admin.holidays.destroy', $holiday->id) }}">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-block" onclick="return confirm('Delete this holiday?')">
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