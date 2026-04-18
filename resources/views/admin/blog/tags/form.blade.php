@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>{{ isset($tag) ? 'Edit Tag' : 'Create Tag' }}</h1>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">

<div class="card-body">

<form method="POST" action="{{ isset($tag) ? route('admin.blog.tags.update', $tag->id) : route('admin.blog.tags.store') }}">

@csrf

@if(isset($tag))
@method('PUT')
@endif

<div class="form-group">
<label>Name</label>
<input type="text" name="name" class="form-control" value="{{ old('name', $tag->name ?? '') }}" required>
</div>

<div class="form-group">
<label>Slug</label>
<input type="text" name="slug" class="form-control" value="{{ old('slug', $tag->slug ?? '') }}">
<small class="text-muted">Leave empty to auto-generate</small>
</div>

<div class="card-footer">
<button type="submit" class="btn btn-primary">
<i class="fas fa-save"></i> {{ isset($tag) ? 'Update' : 'Save' }}
</button>
<a href="{{ route('admin.blog.tags.index') }}" class="btn btn-secondary">Cancel</a>
</div>

</form>

</div>
</div>

</div>
</section>

</div>

@endsection