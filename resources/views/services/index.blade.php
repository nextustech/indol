@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Services</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('services.create') }}" class="btn btn-primary">
<i class="fas fa-plus"></i> Add Service
</a>
</div>

</div>

</div>
</section>


<section class="content">
<div class="container-fluid">

<div class="card">

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>
<tr>
<th>ID</th>
<th>Title</th>
<th>Main Image</th>
<th width="150">Action</th>
</tr>
</thead>

<tbody>

@foreach($services as $service)

<tr>

<td>{{ $service->id }}</td>

<td>{{ $service->title }}</td>

<td>

@if($service->main_image)
<img src="{{ $service->main_image }}" width="70">
@endif

</td>

<td>

<a href="{{ route('services.edit',$service->id) }}" class="btn btn-warning btn-sm">
<i class="fas fa-edit"></i>
</a>

<form action="{{ route('services.destroy',$service->id) }}" method="POST" style="display:inline-block">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm" onclick="return confirm('Delete Service?')">
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
