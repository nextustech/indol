@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>{{ isset($zoomMeeting) ? 'Edit Meeting' : 'Create Meeting' }}</h1>
</div>

</div>
</div>
</section>


<section class="content">
<div class="container-fluid">

<div class="card">

<div class="card-body">

<form action="{{ isset($zoomMeeting) ? route('admin.zoom-meetings.update', $zoomMeeting->id) : route('admin.zoom-meetings.store') }}" method="POST">

@csrf

@if(isset($zoomMeeting))
@method('PUT')
@endif

<div class="row">

<div class="col-md-6">

<div class="form-group">

<label>Topic <span class="text-danger">*</span></label>

<input type="text" name="topic" class="form-control" value="{{ isset($zoomMeeting) ? $zoomMeeting->topic : old('topic') }}" required>

@error('topic')
<span class="text-danger">{{ $message }}</span>
@enderror

</div>

</div>

<div class="col-md-6">

<div class="form-group">

<label>Agenda</label>

<textarea name="agenda" class="form-control" rows="1">{{ isset($zoomMeeting) ? $zoomMeeting->agenda : old('agenda') }}</textarea>

</div>

</div>

</div>

<div class="row">

<div class="col-md-6">

<div class="form-group">

<label>Start Time <span class="text-danger">*</span></label>

<input type="datetime-local" name="start_time" class="form-control" value="{{ isset($zoomMeeting) ? \Carbon\Carbon::parse($zoomMeeting->start_time)->format('Y-m-d\TH:i') : old('start_time') }}" required>

@error('start_time')
<span class="text-danger">{{ $message }}</span>
@enderror

</div>

</div>

<div class="col-md-6">

<div class="form-group">

<label>Duration (minutes) <span class="text-danger">*</span></label>

<select name="duration" class="form-control" required>

<option value="15" {{ isset($zoomMeeting) && $zoomMeeting->duration == 15 ? 'selected' : '' }}>15 min</option>

<option value="30" {{ isset($zoomMeeting) && $zoomMeeting->duration == 30 ? 'selected' : '' }}>30 min</option>

<option value="45" {{ isset($zoomMeeting) && $zoomMeeting->duration == 45 ? 'selected' : '' }}>45 min</option>

<option value="60" {{ isset($zoomMeeting) && $zoomMeeting->duration == 60 ? 'selected' : '' }}>1 hour</option>

<option value="90" {{ isset($zoomMeeting) && $zoomMeeting->duration == 90 ? 'selected' : '' }}>1.5 hours</option>

<option value="120" {{ isset($zoomMeeting) && $zoomMeeting->duration == 120 ? 'selected' : '' }}>2 hours</option>

<option value="180" {{ isset($zoomMeeting) && $zoomMeeting->duration == 180 ? 'selected' : '' }}>3 hours</option>

<option value="240" {{ isset($zoomMeeting) && $zoomMeeting->duration == 240 ? 'selected' : '' }}>4 hours</option>

</select>

</div>

</div>

</div>

<div class="row">

<div class="col-md-6">

<div class="form-group">

<label>Timezone</label>

<select name="timezone" class="form-control">

<option value="Asia/Kolkata" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST)</option>

<option value="Asia/Dhaka" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'Asia/Dhaka' ? 'selected' : '' }}>Asia/Dhaka (BST)</option>

<option value="Asia/Karachi" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'Asia/Karachi' ? 'selected' : '' }}>Asia/Karachi (PKT)</option>

<option value="Asia/Dubai" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai (GST)</option>

<option value="Asia/Singapore" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'Asia/Singapore' ? 'selected' : '' }}>Asia/Singapore (SGT)</option>

<option value="Asia/Bangkok" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'Asia/Bangkok' ? 'selected' : '' }}>Asia/Bangkok (ICT)</option>

<option value="Asia/Jakarta" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>

<option value="Europe/London" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>

<option value="Europe/Paris" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris (CET)</option>

<option value="America/New_York" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>

<option value="America/Los_Angeles" {{ isset($zoomMeeting) && $zoomMeeting->timezone == 'America/Los_Angeles' ? 'selected' : '' }}>America/Los_Angeles (PST)</option>

</select>

</div>

</div>

</div>

<div class="row mt-3">

<div class="col-md-12">

<button type="submit" class="btn btn-primary">
<i class="fas fa-save"></i> {{ isset($zoomMeeting) ? 'Update' : 'Create' }} Meeting
</button>

<a href="{{ route('admin.zoom-meetings.index') }}" class="btn btn-secondary">Cancel</a>

</div>

</div>

</form>

</div>
</div>

</div>
</section>

</div>

@endsection