@extends('layouts.backend')

@section('content')
<div class="content-wrapper">
<div class="content mt-3">
<div class="container-fluid">

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Doctors</h5>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add Doctor</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Branch</th>
            </tr>

            @foreach($doctors as $doc)
            <tr>
                <td>{{ $doc->name }}</td>
                <td>{{ $doc->branch->branchName }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

</div>
</div>
</div>
@endsection
