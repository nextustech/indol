@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Zoom Meetings</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.zoom-meetings.create') }}" class="btn btn-primary">
<i class="fas fa-plus"></i> Create Meeting
</a>
</div>

</div>
</div>
</section>


<section class="content">
<div class="container-fluid">

<div class="card">

<div class="card-body table-responsive">

<table class="table table-bordered table-striped data-table">

<thead>
<tr>
<th>ID</th>
<th>Topic</th>
<th>Start Time</th>
<th>Duration</th>
<th>Status</th>
<th>Join URL</th>
<th width="180">Action</th>
</tr>
</thead>

<tbody>

@foreach($meetings as $meeting)

<tr>
<td>{{ $meeting->id }}</td>
<td>{{ $meeting->topic }}</td>
<td>{{ \Carbon\Carbon::parse($meeting->start_time)->format('d M Y, h:i A') }}</td>
<td>{{ $meeting->duration }} min</td>
<td>
@switch($meeting->status)
@case('scheduled')
<span class="badge badge-info">Scheduled</span>
@break
@case('started')
<span class="badge badge-success">Started</span>
@break
@case('ended')
<span class="badge badge-secondary">Ended</span>
@break
@case('cancelled')
<span class="badge badge-danger">Cancelled</span>
@break
@default
<span class="badge badge-warning">{{ $meeting->status }}</span>
@endswitch
</td>
<td>
@if($meeting->join_url)
<a href="{{ $meeting->join_url }}" target="_blank" class="btn btn-primary btn-sm">
<i class="fas fa-video"></i> Join
</a>
@else
<span class="text-muted">-</span>
@endif
</td>
<td>

<a href="{{ route('admin.zoom-meetings.show', $meeting->id) }}" class="btn btn-info btn-sm">
<i class="fas fa-eye"></i>
</a>

<a href="{{ route('admin.zoom-meetings.edit', $meeting->id) }}" class="btn btn-warning btn-sm">
<i class="fas fa-edit"></i>
</a>

<form action="{{ route('admin.zoom-meetings.destroy', $meeting->id) }}" method="POST" style="display:inline-block">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Delete meeting?')">
<i class="fas fa-trash"></i>
</button>
</form>

</td>
</tr>

@endforeach

</tbody>

</table>

</div>
</div>

</div>
</section>

</div>

@endsection