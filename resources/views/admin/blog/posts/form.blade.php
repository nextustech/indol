@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h1>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">

<div class="card-body">

@php
$formAction = isset($post) ? route('admin.blogs.update', $post->id) : route('admin.blogs.store');
@endphp

<form method="POST" action="{{ $formAction }}" enctype="multipart/form-data">

@csrf

@if(isset($post))
@method('PUT')
@endif

<div class="row">

<div class="col-md-8">

<div class="form-group">
<label>Title</label>
<input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required>
</div>

<div class="form-group">
<label>Slug</label>
<input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}">
<small class="text-muted">Leave empty to auto-generate from title</small>
</div>

<div class="form-group">
<label>Short Description</label>
<textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $post->short_description ?? '') }}</textarea>
</div>

<div class="form-group">
<label>Content</label>
<textarea name="content" id="editor" class="form-control" rows="15">{{ old('content', $post->content ?? '') }}</textarea>
</div>

</div>

<div class="col-md-4">

<div class="form-group">
<label>Category</label>
<select name="blog_category_id" class="form-control">
<option value="">Select Category</option>
@foreach($categories as $cat)
<option value="{{ $cat->id }}" @selected(old('blog_category_id', $post->blog_category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>Featured Image</label>
<div class="input-group">
<input type="text" name="featured_image" id="featured_image" class="form-control" value="{{ old('featured_image', $post->featured_image ?? '') }}">
<div class="input-group-append">
<button type="button" class="btn btn-primary" onclick="openFileManager('featured_image')">
<i class="fas fa-folder-open"></i>
</button>
</div>
</div>
@if(old('featured_image', $post->featured_image ?? ''))
<img src="{{ old('featured_image', $post->featured_image ?? '') }}" class="img-fluid mt-2" style="max-height:150px">
@endif
</div>

<div class="form-group">
<label>Status</label>
<select name="status" class="form-control" id="statusSelect">
<option value="draft" @selected(old('status', $post->status ?? 'draft') == 'draft')>Draft</option>
<option value="published" @selected(old('status', $post->status ?? '') == 'published')>Published</option>
<option value="scheduled" @selected(old('status', $post->status ?? '') == 'scheduled')>Scheduled</option>
</select>
</div>

<div class="form-group" id="scheduledField" style="display: none;">
<label>Schedule Date</label>
<input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at', $post->scheduled_at ?? '') }}">
</div>

<div class="form-group">
<label>Tags</label>
<select name="tag_ids[]" class="form-control" multiple>
@foreach($tags as $tag)
<option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tag_ids', $selectedTags ?? [])))>{{ $tag->name }}</option>
@endforeach
</select>
<small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
</div>

<div class="form-group">
<div class="custom-control custom-checkbox">
<input type="checkbox" name="allow_comments" class="custom-control-input" id="allow_comments" @checked(old('allow_comments', $post->allow_comments ?? true))>
<label class="custom-control-label" for="allow_comments">Allow Comments</label>
</div>
</div>

<hr>

<h5>SEO Settings</h5>

<div class="form-group">
<label>Meta Title</label>
<input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title ?? '') }}">
</div>

<div class="form-group">
<label>Meta Description</label>
<textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
</div>

<div class="form-group">
<label>Meta Keywords</label>
<input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}">
</div>

<hr>

<h5>Open Graph</h5>

<div class="form-group">
<label>OG Title</label>
<input type="text" name="og_title" class="form-control" value="{{ old('og_title', $post->og_title ?? '') }}">
</div>

<div class="form-group">
<label>OG Description</label>
<textarea name="og_description" class="form-control" rows="2">{{ old('og_description', $post->og_description ?? '') }}</textarea>
</div>

<div class="form-group">
<label>OG Image</label>
<div class="input-group">
<input type="text" name="og_image" id="og_image" class="form-control" value="{{ old('og_image', $post->og_image ?? '') }}">
<div class="input-group-append">
<button type="button" class="btn btn-primary" onclick="openFileManager('og_image')">
<i class="fas fa-folder-open"></i>
</button>
</div>
</div>
</div>

</div>

</div>

<div class="card-footer">
<button type="submit" class="btn btn-primary">
<i class="fas fa-save"></i> {{ isset($post) ? 'Update' : 'Save' }}
</button>
<a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
</div>

</form>

</div>
</div>

</div>
</section>

</div>

@push('scripts')
<script>
document.getElementById('statusSelect').addEventListener('change', function() {
    document.getElementById('scheduledField').style.display = this.value === 'scheduled' ? 'block' : 'none';
});

function openFileManager(target) {
    window.open('/laravel-filemanager?type=image&target=' + target, 'FileManager', 'width=900,height=600');
}

window.fmCallback = function(url) {
    var target = window.fmTarget;
    document.getElementById(target).value = url;
};
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.0/classic/translations/en.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor'), {
    language: 'en',
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=image',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=image&_token={{ csrf_token() }}',
    filebrowserBrowseUrl: '/laravel-filemanager?type=file',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=file&_token={{ csrf_token() }}',
    height: '400px'
}).catch(error => console.error(error));
</script>
@endpush

@endsection
