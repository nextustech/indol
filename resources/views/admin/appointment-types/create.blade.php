@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Add Appointment Type</h1>
</div>

<div class="col-sm-6">
<a href="{{ route('admin.appointment-types.index') }}" class="btn btn-default">
    <i class="fas fa-arrow-left"></i> Back
</a>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card card-primary">
<div class="card-header">
    <h3 class="card-title">Appointment Type Details</h3>
</div>

<form method="POST" action="{{ route('admin.appointment-types.store') }}">
@csrf

<div class="card-body">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="duration">Duration (minutes) *</label>
            <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                   id="duration" name="duration" value="{{ old('duration', 30) }}" required min="1">
            @error('duration')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                   id="price" name="price" value="{{ old('price') }}" step="0.01" min="0">
            @error('price')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="is_active">Status</label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

</div>

<div class="card-footer">
<button type="submit" class="btn btn-primary">Create</button>
<a href="{{ route('admin.appointment-types.index') }}" class="btn btn-default">Cancel</a>
</div>

</form>

</div>

</div>
</section>

</div>

@endsection