@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Blog Comments</h1>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">

<div class="card-body table-responsive">

<table class="table table-bordered table-striped">

<thead>
<tr>
<th>ID</th>
<th>Post</th>
<th>Name</th>
<th>Comment</th>
<th>Status</th>
<th>Date</th>
<th width="180">Action</th>
</tr>
</thead>

<tbody>

@forelse($comments as $comment)

<tr>
<td>{{ $comment->id }}</td>
<td>
<a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank">
{{ Str::limit($comment->post->title, 30) }}
</a>
</td>
<td>
<strong>{{ $comment->name }}</strong><br>
<small class="text-muted">{{ $comment->email }}</small>
</td>
<td>{{ Str::limit($comment->comment, 80) }}</td>
<td>
@if($comment->is_approved)
<span class="badge badge-success">Approved</span>
@else
<span class="badge badge-warning">Pending</span>
@endif
</td>
<td>{{ $comment->created_at->format('d M Y') }}</td>
<td>
@if(!$comment->is_approved)
<form method="POST" action="{{ route('admin.blog.comments.approve', $comment->id) }}" style="display:inline-block">
@csrf
<button class="btn btn-success btn-sm" onclick="return confirm('Approve this comment?')">
<i class="fas fa-check"></i>
</button>
</form>
@endif
<form method="POST" action="{{ route('admin.blog.comments.delete', $comment->id) }}" style="display:inline-block">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Delete this comment?')">
<i class="fas fa-trash"></i>
</button>
</form>
</td>
</tr>

@empty

<tr>
<td colspan="7" class="text-center">No comments found.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="card-footer">
{{ $comments->links() }}
</div>

</div>

</div>
</section>

</div>

@endsection