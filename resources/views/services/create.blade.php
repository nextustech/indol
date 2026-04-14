@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">
<h1>Add Service</h1>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<form action="{{ route('services.store') }}" method="POST">

@csrf

<div class="row">

<div class="col-md-6">
<div class="form-group">
<label>Title</label>
<input type="text" name="title" id="title" class="form-control">
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label>Slug</label>
<input type="text" name="slug" id="slug" class="form-control">
</div>
</div>

</div>


<div class="row">

<div class="col-md-6">

<label>Banner Image</label>

<div class="input-group">

<input id="banner_image" class="form-control" type="text" name="banner_image">

<div class="input-group-append">

<a id="lfm_banner"
data-input="banner_image"
data-preview="banner_holder"
class="btn btn-primary">

<i class="fas fa-image"></i> Choose

</a>

</div>

</div>

<div id="banner_holder" style="margin-top:10px;"></div>

</div>


<div class="col-md-6">

<label>Main Image</label>

<div class="input-group">

<input id="main_image" class="form-control" type="text" name="main_image">

<div class="input-group-append">

<a id="lfm_main"
data-input="main_image"
data-preview="main_holder"
class="btn btn-primary">

Choose

</a>

</div>

</div>

<div id="main_holder" style="margin-top:10px;"></div>

</div>

</div>


<br>

<div class="row">

<div class="col-md-6">

<label>Extra Image A</label>

<div class="input-group">

<input id="extraImageA" class="form-control" type="text" name="extraImageA">

<div class="input-group-append">

<a id="lfm_extraA"
data-input="extraImageA"
data-preview="extraA_holder"
class="btn btn-primary">

Choose

</a>

</div>

</div>

<div id="extraA_holder" style="margin-top:10px;"></div>

</div>

<div class="col-md-6">

<label>Extra Image B</label>

<div class="input-group">

<input id="extraImageB" class="form-control" type="text" name="extraImageB">

<div class="input-group-append">

<a id="lfm_extraB"
data-input="extraImageB"
data-preview="extraB_holder"
class="btn btn-primary">

Choose

</a>

</div>

</div>

<div id="extraB_holder" style="margin-top:10px;"></div>

</div>

</div>


<br>

<div class="form-group">
<label>Short Description</label>
<textarea name="short_description" class="form-control"></textarea>
</div>


<div class="form-group">
<label>Description</label>
<textarea name="description" id="editor" class="form-control"></textarea>
</div>


<button class="btn btn-success">
Save Service
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

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>

var route_prefix = "/laravel-filemanager";

$('#lfm_banner').filemanager('image', {prefix: route_prefix});
$('#lfm_main').filemanager('image', {prefix: route_prefix});
$('#lfm_extraA').filemanager('image', {prefix: route_prefix});
$('#lfm_extraB').filemanager('image', {prefix: route_prefix});


/* slug generator */

$('#title').keyup(function(){

let slug = $(this).val()
.toLowerCase()
.replace(/ /g,'-')
.replace(/[^\w-]+/g,'');

$('#slug').val(slug);

});


/* CKEditor */

CKEDITOR.replace('editor', {

filebrowserBrowseUrl: '/laravel-filemanager?type=Images',

filebrowserUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',

filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images'

});

</script>

@endsection
