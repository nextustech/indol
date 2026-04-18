@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Contact Message #{{ $contact->id }}</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.IndexContact') }}" class="btn btn-default">
    <i class="fas fa-arrow-left"></i> Back to List
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

<div class="row">

<div class="col-md-8">

<div class="card">
<div class="card-header">
    <h3 class="card-title">
        <strong>Subject: {{ $contact->subject }}</strong>
    </h3>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Message:</label>
                <div class="border p-3 rounded" style="background-color: #f9f9f9; min-height: 150px;">
                    {!! nl2br(e($contact->message)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>

<div class="col-md-4">

<div class="card">
<div class="card-header">
    <h3 class="card-title">Sender Information</h3>
</div>
<div class="card-body">

<div class="form-group">
    <label>Name:</label>
    <p><strong>{{ $contact->name }}</strong></p>
</div>

<div class="form-group">
    <label>Email:</label>
    <p>
        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
    </p>
</div>

<div class="form-group">
    <label>Phone:</label>
    <p>
        <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
    </p>
</div>

<div class="form-group">
    <label>Status:</label>
    <p>
        @switch($contact->status)
            @case('new')
                <span class="badge badge-warning">New</span>
                @break
            @case('read')
                <span class="badge badge-info">Read</span>
                @break
            @case('replied')
                <span class="badge badge-success">Replied</span>
                @break
            @case('archived')
                <span class="badge badge-secondary">Archived</span>
                @break
            @default
                <span class="badge badge-secondary">{{ $contact->status }}</span>
        @endswitch
    </p>
</div>

<div class="form-group">
    <label>Received:</label>
    <p>{{ $contact->created_at->format('d M Y, h:i A') }}</p>
</div>

<div class="form-group">
    <label>Actions:</label>
    <div class="btn-group-vertical w-100">
        @if(!$contact->is_read)
        <form method="POST" action="{{ route('admin.contacts.markRead', $contact->id) }}">
            @csrf
            <button class="btn btn-success btn-block" onclick="return confirm('Mark as read?')">
                <i class="fas fa-check"></i> Mark as Read
            </button>
        </form>
        @else
        <form method="POST" action="{{ route('admin.contacts.markUnread', $contact->id) }}">
            @csrf
            <button class="btn btn-warning btn-block" onclick="return confirm('Mark as unread?')">
                <i class="fas fa-envelope"></i> Mark as Unread
            </button>
        </form>
        @endif
        <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-block" onclick="return confirm('Delete this message? This action cannot be undone.')">
                <i class="fas fa-trash"></i> Delete Message
            </button>
        </form>
        <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" class="btn btn-primary btn-block">
            <i class="fas fa-reply"></i> Reply via Email
        </a>
    </div>
</div>

</div>
</div>

</div>

</div>

</div>
</section>

</div>

@endsection
