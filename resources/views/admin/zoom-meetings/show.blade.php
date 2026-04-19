@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>{{ $zoomMeeting->topic }}</h1>
</div>

<div class="col-sm-6 text-right">

@if($zoomMeeting->join_url)
<a href="{{ $zoomMeeting->join_url }}" target="_blank" class="btn btn-primary">
<i class="fas fa-video"></i> Join Meeting
</a>
@endif

<a href="{{ route('admin.zoom-meetings.index') }}" class="btn btn-secondary">
<i class="fas fa-arrow-left"></i> Back
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
<h3 class="card-title">Meeting Details</h3>
</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
<th width="200">Meeting ID</th>
<td>{{ $zoomMeeting->meeting_id ?? '-' }}</td>
</tr>

<tr>
<th>Topic</th>
<td>{{ $zoomMeeting->topic }}</td>
</tr>

<tr>
<th>Agenda</th>
<td>{{ $zoomMeeting->agenda ?? '-' }}</td>
</tr>

<tr>
<th>Start Time</th>
<td>{{ \Carbon\Carbon::parse($zoomMeeting->start_time)->format('d M Y, h:i A') }}</td>
</tr>

<tr>
<th>Duration</th>
<td>{{ $zoomMeeting->duration }} minutes</td>
</tr>

<tr>
<th>Timezone</th>
<td>{{ $zoomMeeting->timezone }}</td>
</tr>

<tr>
<th>Status</th>
<td>
@switch($zoomMeeting->status)
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
<span class="badge badge-warning">{{ $zoomMeeting->status }}</span>
@endswitch
</td>
</tr>

<tr>
<th>Type</th>
<td>{{ ucfirst($zoomMeeting->type) }}</td>
</tr>

<tr>
<th>Created At</th>
<td>{{ $zoomMeeting->created_at->format('d M Y, h:i A') }}</td>
</tr>

</table>

</div>
</div>

</div>

<div class="col-md-4">

<div class="card">

<div class="card-header">
<h3 class="card-title">Meeting Links</h3>
</div>

<div class="card-body">

@if($zoomMeeting->join_url)
<div class="form-group">
<label>Join URL</label>
<div class="input-group">
<input type="text" class="form-control" value="{{ $zoomMeeting->join_url }}" id="joinUrl" readonly>
<div class="input-group-append">
<button class="btn btn-outline-secondary" onclick="copyToClipboard('joinUrl')">
<i class="fas fa-copy"></i>
</button>
</div>
</div>
</div>
@endif

@if($zoomMeeting->start_url)
<div class="form-group">
<label>Start URL</label>
<div class="input-group">
<input type="text" class="form-control" value="{{ $zoomMeeting->start_url }}" id="startUrl" readonly>
<div class="input-group-append">
<button class="btn btn-outline-secondary" onclick="copyToClipboard('startUrl')">
<i class="fas fa-copy"></i>
</button>
</div>
</div>
</div>
@endif

@if($zoomMeeting->password)
<div class="form-group">
<label>Password</label>
<div class="input-group">
<input type="text" class="form-control" value="{{ $zoomMeeting->password }}" id="password" readonly>
<div class="input-group-append">
<button class="btn btn-outline-secondary" onclick="copyToClipboard('password')">
<i class="fas fa-copy"></i>
</button>
</div>
</div>
</div>
@endif

@if($zoomMeeting->host_email)
<div class="form-group">
<label>Host Email</label>
<p>{{ $zoomMeeting->host_email }}</p>
</div>
@endif

</div>
</div>

<div class="card">

<div class="card-header">
<h3 class="card-title">Actions</h3>
</div>

<div class="card-body">

@if($zoomMeeting->status == 'scheduled')
<a href="{{ route('admin.zoom-meetings.start', $zoomMeeting->id) }}" class="btn btn-success btn-block mb-2">
<i class="fas fa-play"></i> Start Meeting
</a>

<form action="{{ route('admin.zoom-meetings.end', $zoomMeeting->id) }}" method="POST" style="display:inline-block; width: 100%">
@csrf
<button type="submit" class="btn btn-warning btn-block mb-2" onclick="return confirm('End this meeting?')">
<i class="fas fa-stop"></i> End Meeting
</button>
</form>
@endif

<a href="{{ route('admin.zoom-meetings.sync', $zoomMeeting->id) }}" class="btn btn-info btn-block mb-2">
<i class="fas fa-sync"></i> Sync with Zoom
</a>

<a href="{{ route('admin.zoom-meetings.edit', $zoomMeeting->id) }}" class="btn btn-primary btn-block mb-2">
<i class="fas fa-edit"></i> Edit Meeting
</a>

<form action="{{ route('admin.zoom-meetings.destroy', $zoomMeeting->id) }}" method="POST">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Delete this meeting?')">
<i class="fas fa-trash"></i> Delete Meeting
</button>
</form>

</div>
</div>

</div>

</div>

</div>
</section>

</div>

@push('scripts')
<script>
function copyToClipboard(elementId) {
    var copyText = document.getElementById(elementId);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert('Copied to clipboard!');
}
</script>
@endpush

@endsection