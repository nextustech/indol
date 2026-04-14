@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Sliders</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
<i class="fas fa-plus"></i> Add Slider
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
<th>Title</th>
<th>Order</th>
<th>Status</th>
<th width="150">Action</th>
</tr>
</thead>

<tbody>

@foreach($sliders as $slider)

<tr>

<td>{{ $slider->id }}</td>

<td>
<img src="{{ $slider->image }}"
width="80">
</td>

<td>{{ $slider->title }}</td>

<td>{{ $slider->order }}</td>

<td>
@if($slider->status)
<span class="badge badge-success">Active</span>
@else
<span class="badge badge-danger">Inactive</span>
@endif
</td>

<td>

<a href="{{ route('admin.sliders.edit',$slider->id) }}"
class="btn btn-warning btn-sm">
<i class="fas fa-edit"></i>
</a>

<form action="{{ route('admin.sliders.destroy',$slider->id) }}"
method="POST"
style="display:inline-block">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('Delete slider?')">
<i class="fas fa-trash"></i>
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>

</div>
</section>

</div>

@endsection
