@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Contact Messages</h1>
</div>

<div class="col-sm-6">
@if($unreadCount > 0)
<span class="badge badge-warning">{{ $unreadCount }} unread</span>
@endif
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">
<div class="card-header">
    <form method="GET" action="{{ route('admin.IndexContact') }}" class="form-inline">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
            <span class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </span>
        </div>
        <div class="input-group ml-2">
            <select name="unread" class="form-control" onchange="this.form.submit()">
                <option value="">All Messages</option>
                <option value="1" {{ request('unread') == '1' ? 'selected' : '' }}>Unread</option>
            </select>
        </div>
        <div class="input-group ml-2">
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
            </select>
        </div>
        @if(request()->anyFilled(['search', 'unread', 'status']))
        <div class="input-group ml-2">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-default">
                <i class="fas fa-times"></i> Clear
            </a>
        </div>
        @endif
    </form>
</div>

<div class="card-body table-responsive">

<table class="table table-bordered table-striped">

<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Subject</th>
    <th>Status</th>
    <th>Date</th>
    <th width="120">Action</th>
</tr>
</thead>

<tbody>

@forelse($contacts as $contact)

<tr class="{{ !$contact->is_read ? 'bg-light' : '' }}">
    <td>
        @if(!$contact->is_read)
        <span class="badge badge-danger">NEW</span>
        @endif
        {{ $contact->id }}
    </td>
    <td>
        <strong>{{ $contact->name }}</strong>
    </td>
    <td>
        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
    </td>
    <td>
        <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
    </td>
    <td>{{ Str::limit($contact->subject, 30) }}</td>
    <td>
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
    </td>
    <td>{{ $contact->created_at->format('d M Y, h:i A') }}</td>
    <td>
        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-eye"></i>
        </a>
        <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this message?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
</tr>

@empty

<tr>
    <td colspan="8" class="text-center">No contact messages found.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="card-footer">
{{ $contacts->links() }}
</div>

</div>

</div>
</section>

</div>

@endsection
