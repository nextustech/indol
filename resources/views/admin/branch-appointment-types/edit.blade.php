@extends('layouts.backend')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">
<h1>Edit Branch Appointment Type</h1>
</div>

<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('admin.branch-appointment-types.index') }}">Branch Appointment Types</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol>
</div>

</div>
</div>
</section>

<section class="content">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<form method="POST" action="{{ route('admin.branch-appointment-types.update', $branchType->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Branch <span class="text-danger">*</span></label>
        <select name="branch_id" class="form-control @error('branch_id') is-invalid @enderror" required>
            <option value="">Select Branch</option>
            @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ old('branch_id', $branchType->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->branchName }}</option>
            @endforeach
        </select>
        @error('branch_id')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Appointment Type <span class="text-danger">*</span></label>
        <select name="appointment_type_id" class="form-control @error('appointment_type_id') is-invalid @enderror" required>
            <option value="">Select Appointment Type</option>
            @foreach($appointmentTypes as $type)
            <option value="{{ $type->id }}" {{ old('appointment_type_id', $branchType->appointment_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }} ({{ $type->duration }} min)</option>
            @endforeach
        </select>
        @error('appointment_type_id')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update
        </button>
        <a href="{{ route('admin.branch-appointment-types.index') }}" class="btn btn-default">
            Cancel
        </a>
    </div>

</form>

</div>
</div>

</div>
</section>

</div>

@endsection