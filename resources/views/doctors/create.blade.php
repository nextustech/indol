@extends('layouts.backend')

@section('content')
<div class="content-wrapper">
<div class="content mt-3">
<div class="container-fluid">

<div class="card">
    <div class="card-header"><h5>Add Doctor</h5></div>

    <div class="card-body">
        <form method="POST" action="{{ route('doctors.store') }}">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input name="name" class="form-control">
            </div>

            <div class="form-group">
                <label>Branch</label>
                <select name="branch_id" class="form-control">
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}">{{ $b->branchName }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success">Save</button>
        </form>
    </div>
</div>

</div>
</div>
</div>
@endsection
