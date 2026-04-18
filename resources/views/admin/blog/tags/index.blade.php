@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Blog Tags</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.blog.tags.create') }}" class="btn btn-primary">
<i class="fas fa-plus"></i> Add Tag
</a>
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
<th>Name</th>
<th>Slug</th>
<th>Posts</th>
<th width="150">Action</th>
</tr>
</thead>

<tbody>

@forelse($tags as $tag)

<tr>
<td>{{ $tag->id }}</td>
<td>{{ $tag->name }}</td>
<td>{{ $tag->slug }}</td>
<td>{{ $tag->posts_count }}</td>
<td>
<a href="{{ route('admin.blog.tags.edit', $tag->id) }}" class="btn btn-warning btn-sm">
<i class="fas fa-edit"></i>
</a>
<form action="{{ route('admin.blog.tags.destroy', $tag->id) }}" method="POST" style="display:inline-block">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Delete this tag?')">
<i class="fas fa-trash"></i>
</button>
</form>
</td>
</tr>

@empty

<tr>
<td colspan="5" class="text-center">No tags found.</td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

</div>
</section>

</div>

@endsection