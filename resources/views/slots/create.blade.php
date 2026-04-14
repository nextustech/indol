@extends('layouts.backend')

@section('content')

<div class="content-wrapper">
    <div class="content mt-3">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header"><h5>Create Slot</h5></div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('slots.store') }}">
                        @csrf

                        <div class="row">

                        <div class="col-md-3">
                        <label>Branch</label>
                        <select name="branch_id" class="form-control">
                        @foreach($branches as $b)
                        <option value="{{ $b->id }}">{{ $b->branchName }}</option>
                        @endforeach
                        </select>
                        </div>

                        <div class="col-md-3">
                        <label>Doctor</label>
                        <select name="doctor_id" class="form-control">
                        <option value="">All</option>
                        @foreach($doctors as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                        </select>
                        </div>

                        <div class="col-md-2">
                        <label>Start</label>
                        <input type="time" name="start_time" class="form-control">
                        </div>

                        <div class="col-md-2">
                        <label>End</label>
                        <input type="time" name="end_time" class="form-control">
                        </div>

                        <div class="col-md-2">
                        <label>Max</label>
                        <input type="number" name="max_booking" class="form-control" value="1">
                        </div>

                        <div class="col-md-4 mt-3">
                        <label>Days</label>
                        <select name="days[]" class="form-control" multiple>
                        <option value="0">Sun</option>
                        <option value="1">Mon</option>
                        <option value="2">Tue</option>
                        <option value="3">Wed</option>
                        <option value="4">Thu</option>
                        <option value="5">Fri</option>
                        <option value="6">Sat</option>
                        </select>
                        </div>

                        </div>

                        <button class="btn btn-success mt-3">Save</button>

                        </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
