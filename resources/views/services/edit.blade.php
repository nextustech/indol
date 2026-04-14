@extends('layouts.admin')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">
<h1>Edit Service</h1>
</div>
</section>


<section class="content">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<form action="{{ route('services.update',$service->id) }}" method="POST">

@csrf
@method('PUT')


<div class="form-group">
<label>Title</label>
<input type="text" name="title" value="{{ $service->title }}" class="form-control">
</div>


<div class="form-group">
<label>Banner Image</label>

<div class="input-group">

<input id="banner_image" class="form-control" type="text" name="banner_image" value="{{ $service->banner_image }}">

<span class="input-group-btn">

<a id="lfm_banner" data-input="banner_image" data-preview="banner_holder" class="btn btn-primary">
Choose
</a>

</span>

</div>

@if($service->banner_image)
<img src="{{ $service->banner_image }}" style="margin-top:10px;height:100px;">
@endif

</div>



<div class="form-group">
<label>Main Image</label>

<div class="input-group">

<input id="main_image" class="form-control" type="text" name="main_image" value="{{ $service->main_image }}">

<span class="input-group-btn">

<a id="lfm_main" data-input="main_image" data-preview="main_holder" class="btn btn-primary">
Choose
</a>

</span>

</div>

@if($service->main_image)
<img src="{{ $service->main_image }}" style="margin-top:10px;height:100px;">
@endif

</div>



<div class="form-group">
<label>Extra Image A</label>

<input id="extraImageA" class="form-control" type="text" name="extraImageA" value="{{ $service->extraImageA }}">

</div>


<div class="form-group">
<label>Extra Image B</label>

<input id="extraImageB" class="form-control" type="text" name="extraImageB" value="{{ $service->extraImageB }}">

</div>



<div class="form-group">
<label>Short Description</label>

<textarea name="short_description" class="form-control">
{{ $service->short_description }}
</textarea>

</div>


<div class="form-group">
<label>Description</label>

<textarea name="description" id="editor" class="form-control">
{{ $service->description }}
</textarea>

</div>


<button class="btn btn-success">
Update Service
</button>

</form>

</div>
</div>

</div>
</section>

</div>

@endsection


@section('page-js')

<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

<script>

$('#lfm_banner').filemanager('image');
$('#lfm_main').filemanager('image');
$('#lfm_extraA').filemanager('image');
$('#lfm_extraB').filemanager('image');

</script>

@endsection
