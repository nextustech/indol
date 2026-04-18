@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Blog Categories</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.blog.categories.create') }}" class="btn btn-primary">
<i class="fas fa-plus"></i> Add Category
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
<th>Image</th>
<th>Name</th>
<th>Slug</th>
<th>Parent</th>
<th>Posts</th>
<th>Status</th>
<th width="150">Action</th>
</tr>
</thead>

<tbody>

@forelse($categories as $category)

<tr>
<td>{{ $category->id }}</td>
<td>
@if($category->image)
<img src="{{ $category->image }}" width="50">
@else
<span class="text-muted">-</span>
@endif
</td>
<td>{{ $category->name }}</td>
<td>{{ $category->slug }}</td>
<td>{{ $category->parent->name ?? '-' }}</td>
<td>{{ $category->posts_count }}</td>
<td>
@if($category->status)
<span class="badge badge-success">Active</span>
@else
<span class="badge badge-secondary">Inactive</span>
@endif
</td>
<td>
<a href="{{ route('admin.blog.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
<i class="fas fa-edit"></i>
</a>
<form action="{{ route('admin.blog.categories.destroy', $category->id) }}" method="POST" style="display:inline-block">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')">
<i class="fas fa-trash"></i>
</button>
</form>
</td>
</tr>

@empty

<tr>
<td colspan="8" class="text-center">No categories found.</td>
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