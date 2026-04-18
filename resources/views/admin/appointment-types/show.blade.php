@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>{{ $appointmentType->name }}</h1>
</div>

<div class="col-sm-6 text-right">
<a href="{{ route('admin.appointment-types.index') }}" class="btn btn-default">
    <i class="fas fa-arrow-left"></i> Back
</a>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="row">

<div class="col-md-6">
<div class="card">
<div class="card-header">
    <h3 class="card-title">Details</h3>
</div>
<div class="card-body">
    <table class="table table-borderless">
        <tr>
            <th>ID:</th>
            <td>{{ $appointmentType->id }}</td>
        </tr>
        <tr>
            <th>Name:</th>
            <td>{{ $appointmentType->name }}</td>
        </tr>
        <tr>
            <th>Duration:</th>
            <td>{{ $appointmentType->duration }} minutes</td>
        </tr>
        <tr>
            <th>Price:</th>
            <td>{{ $appointmentType->price ? '₹' . number_format($appointmentType->price, 2) : '-' }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>
                @if($appointmentType->is_active)
                <span class="badge badge-success">Active</span>
                @else
                <span class="badge badge-danger">Inactive</span>
                @endif
            </td>
        </tr>
    </table>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card">
<div class="card-header">
    <h3 class="card-title">Actions</h3>
</div>
<div class="card-body">
    <a href="{{ route('admin.appointment-types.edit', $appointmentType->id) }}" class="btn btn-warning btn-block">
        <i class="fas fa-edit"></i> Edit
    </a>
    <form method="POST" action="{{ route('admin.appointment-types.destroy', $appointmentType->id) }}">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-block" onclick="return confirm('Delete this type?')">
            <i class="fas fa-trash"></i> Delete
        </button>
    </form>
</div>
</div>
</div>

</div>

</div>
</section>

</div>

@endsection