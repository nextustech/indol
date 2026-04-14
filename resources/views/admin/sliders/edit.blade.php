@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<h1>{{ isset($slider) ? 'Edit Slider' : 'Create Slider' }}</h1>

</div>
</section>


<section class="content">
<div class="container-fluid">

<div class="card card-primary">

<form method="POST"
action="{{ isset($slider) ? route('admin.sliders.update',$slider->id) : route('admin.sliders.store') }}">

@csrf
@if(isset($slider))
@method('PUT')
@endif

<div class="card-body">

<div class="form-group">
<label>Subtitle</label>
<input type="text" name="sub_title"
value="{{ $slider->sub_title ?? '' }}"
class="form-control">
</div>


<div class="form-group">
<label>Title *</label>
<input type="text" name="title"
value="{{ $slider->title ?? '' }}"
class="form-control" required>
</div>


<div class="form-group">
<label>Description</label>
<textarea name="description"
class="form-control">{{ $slider->description ?? '' }}</textarea>
</div>


<div class="form-group">
<label>Button Text</label>
<input type="text" name="button_text"
value="{{ $slider->button_text ?? '' }}"
class="form-control">
</div>


<div class="form-group">
<label>Button Link</label>
<input type="text" name="button_link"
value="{{ $slider->button_link ?? '' }}"
class="form-control">
</div>


<div class="form-group">
<label>Video URL</label>
<input type="text" name="video_url"
value="{{ $slider->video_url ?? '' }}"
class="form-control">
</div>


<div class="form-group">

<label>Image</label>

<div class="input-group">

<span class="input-group-btn">
<a id="lfm"
data-input="thumbnail"
data-preview="holder"
class="btn btn-primary">

<i class="fa fa-picture-o"></i> Choose

</a>
</span>

<input id="thumbnail"
class="form-control"
type="text"
name="image"
value="{{ $slider->image ?? '' }}">

</div>

<img id="holder"
src="{{ $slider->image ?? '' }}"
style="margin-top:15px;max-height:120px;">

</div>


<div class="form-group">
<label>Order</label>
<input type="number" name="order"
value="{{ $slider->order ?? 0 }}"
class="form-control">
</div>


<div class="form-group">
<label>Status</label>

<select name="status" class="form-control">

<option value="1"
{{ ($slider->status ?? 1)==1 ? 'selected':'' }}>
Active
</option>

<option value="0"
{{ ($slider->status ?? 1)==0 ? 'selected':'' }}>
Inactive
</option>

</select>

</div>

</div>


<div class="card-footer">
<button type="submit" class="btn btn-success">
Save
</button>
</div>

</form>

</div>
</div>
</section>

</div>

@endsection

@section('page-js')

<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

<script>
$('#lfm').filemanager('image');
</script>

@endsection
