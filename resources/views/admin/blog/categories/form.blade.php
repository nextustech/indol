@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h1>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">

<div class="card-body">

<form method="POST" action="{{ isset($category) ? route('admin.blog.categories.update', $category->id) : route('admin.blog.categories.store') }}">

@csrf

@if(isset($category))
@method('PUT')
@endif

<div class="form-group">
<label>Name</label>
<input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
</div>

<div class="form-group">
<label>Slug</label>
<input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug ?? '') }}">
<small class="text-muted">Leave empty to auto-generate</small>
</div>

<div class="form-group">
<label>Parent Category</label>
<select name="parent_id" class="form-control">
<option value="">None</option>
@foreach($categories as $cat)
<option value="{{ $cat->id }}" @selected(old('parent_id', $category->parent_id ?? '') == $cat->id)>{{ $cat->name }}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>Description</label>
<textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
</div>

<div class="form-group">
<label>Image</label>
<div class="input-group">
<input type="text" name="image" id="category_image" class="form-control" value="{{ old('image', $category->image ?? '') }}">
<div class="input-group-append">
<button type="button" class="btn btn-primary" onclick="openFileManager('category_image')">
<i class="fas fa-folder-open"></i>
</button>
</div>
</div>
</div>

<div class="form-group">
<label>Order</label>
<input type="number" name="order" class="form-control" value="{{ old('order', $category->order ?? 0) }}">
</div>

<div class="form-group">
<div class="custom-control custom-checkbox">
<input type="checkbox" name="status" class="custom-control-input" id="status" @checked(old('status', $category->status ?? true))>
<label class="custom-control-label" for="status">Active</label>
</div>
</div>

<div class="card-footer">
<button type="submit" class="btn btn-primary">
<i class="fas fa-save"></i> {{ isset($category) ? 'Update' : 'Save' }}
</button>
<a href="{{ route('admin.blog.categories.index') }}" class="btn btn-secondary">Cancel</a>
</div>

</form>

</div>
</div>

</div>
</section>

</div>

@push('scripts')
<script>
function openFileManager(target) {
    window.open('/laravel-filemanager?type=image&target=' + target, 'FileManager', 'width=900,height=600');
}

window.fmCallback = function(url) {
    var target = window.fmTarget;
    document.getElementById(target).value = url;
};
</script>
@endpush

@endsection