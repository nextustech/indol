@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Blog Posts</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
<i class="fas fa-plus"></i> Add Post
</a>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">
<div class="card-header">
<form method="GET" class="form-inline">
<div class="input-group mr-2">
<select name="status" class="form-control">
<option value="">All Status</option>
<option value="draft" @selected(request('status')=='draft')>Draft</option>
<option value="published" @selected(request('status')=='published')>Published</option>
</select>
</div>
<div class="input-group mr-2">
<select name="category" class="form-control">
<option value="">All Categories</option>
@foreach($categories as $cat)
<option value="{{ $cat->id }}" @selected(request('category')==$cat->id)>{{ $cat->name }}</option>
@endforeach
</select>
</div>
<div class="input-group">
<input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
<button type="submit" class="btn btn-primary">
<i class="fas fa-search"></i>
</button>
</div>
</form>
</div>

<div class="card-body table-responsive">

<table class="table table-bordered table-striped">

<thead>
<tr>
<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Category</th>
<th>Author</th>
<th>Status</th>
<th>Views</th>
<th>Date</th>
<th width="150">Action</th>
</tr>
</thead>

<tbody>

@forelse($posts as $post)

<tr>
<td>{{ $post->id }}</td>
<td>
@if($post->featured_image)
<img src="{{ $post->featured_image }}" width="60">
@else
<span class="text-muted">-</span>
@endif
</td>
<td>
<strong>{{ $post->title }}</strong>
@if($post->allow_comments)
<br><small class="text-muted">{{ $post->approvedComments->count() }} comments</small>
@endif
</td>
<td>{{ $post->category->name ?? '-' }}</td>
<td>{{ $post->author->name ?? '-' }}</td>
<td>
@if($post->status == 'published')
<span class="badge badge-success">Published</span>
@elseif($post->status == 'scheduled')
<span class="badge badge-warning">Scheduled</span>
@else
<span class="badge badge-secondary">Draft</span>
@endif
</td>
<td>{{ number_format($post->view_count) }}</td>
<td>{{ $post->created_at->format('d M Y') }}</td>
<td>
<a href="{{ route('admin.blogs.edit',$post->id) }}" class="btn btn-warning btn-sm">
<i class="fas fa-edit"></i>
</a>
<form action="{{ route('admin.blogs.destroy',$post->id) }}" method="POST" style="display:inline-block">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Delete this post?')">
<i class="fas fa-trash"></i>
</button>
</form>
</td>
</tr>

@empty

<tr>
<td colspan="9" class="text-center">No posts found.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="card-footer">
{{ $posts->links() }}
</div>

</div>

</div>
</section>

</div>

@endsection
