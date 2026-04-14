@extends('layouts.backend')

@section('content')

<div class="content-wrapper">
    <div class="content mt-3">
        <div class="container-fluid">

            <div class="card">
                    <div class="card-header"><h5>Holidays</h5>
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('holidays.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <input type="date" name="date" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <input type="text" name="reason" placeholder="Reason" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <select name="branch_id" class="form-control">
                                    <option value="">All Branches</option>
                                    @foreach(\App\Models\Branch::all() as $b)
                                    <option value="{{ $b->id }}">{{ $b->branchName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                            <button class="btn btn-danger">Add Holiday</button>
                            </div>
                        </div>

                        </form>

                        <hr>

                        <table class="table table-bordered mt-3">
                            <tr>
                                <th>Date</th>
                                <th>Branch</th>
                                <th>Reason</th>
                            </tr>

                            @foreach($holidays as $h)
                            <tr>
                                <td>{{ $h->date }}</td>
                                <td>{{ $h->branch->name ?? 'All' }}</td>
                                <td>{{ $h->reason }}</td>
                            </tr>
                        @endforeach

                        </table>

                    </div>
            </div>

        </div>
    </div>
</div>

@endsection
