@extends('layouts.backend')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Collection Reports</h5>
                            </div>

                            {{ Html()->form('GET')->route('dueReportCustom')->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Branch</label>
                                            <select class="form-control" name="branchFilter">
                                                <option value="">All Branches</option>
                                                @foreach( $branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ $branchFilter == $branch->id  ? 'selected':'' }}>
                                                        {{ $branch->branchName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Date Range</label>
                                            <select class="form-control" name="dateFilter">
                                                <option value="today" @if($dateFilter == "today") selected @endif >Today</option>
                                                <option value="yesterday" @if($dateFilter == "yesterday") selected @endif >Yesterday</option>
                                                <option value="this_week" @if($dateFilter == "this_week") selected @endif >This Week</option>
                                                <option value="last_week" @if($dateFilter == "last_week") selected @endif >Last Week</option>
                                                <option value="this_month" @if($dateFilter == "this_month") selected @endif >This Month</option>
                                                <option value="last_month" @if($dateFilter == "last_month") selected @endif >Last Month</option>
                                                <option value="this_year" @if($dateFilter == "this_year") selected @endif >This Year</option>
                                                <option value="last_year" @if($dateFilter == "last_year") selected @endif >Last Year</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-block btn-primary">Submit</button>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Due's Details</h5>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Reg Date</th>
                                        <th>Branch</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Payable</th>
                                        <th>Collection</th>
                                        <th>Discount</th>
                                        <th>Total Due</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($patients)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $patients as $patient )
                                            @if( $patient->payments->sum('amount') > $patient->collections->sum('amount'))
                                                <tr>
                                                        <?php
                                                        $source = $patient->date;
                                                        $regDate = new DateTime($source);
                                                        ?>

                                                    <td>{{ $regDate->format(" j M, y") }}</td>
                                                    <td>
                                                        @foreach( $patient->branches as $branch )
                                                            {{ $branch->branchName }}
                                                        @endforeach
                                                    </td>
                                                    <td><a href="{{ route('patients.show',$patient) }}" data-toggle="tooltip" data-placement="top" title="{{ $patient->diagnosis }}">
                                                            {{ ucfirst($patient->name) }} </a> ( {{ $patient->age }} @if($patient->gender == 1) M  @else  F @endif )
                                                    </td>
                                                    <td> {{ $patient->mobile }} </td>
                                                    <td>{{ $patient->payments->sum('amount') }}</td>

                                                    <td>
                                                        {{  $patient->collections->sum('amount') }}
                                                    </td>
                                                    <td>
                                                        {{  $patient->collections->sum('discount') }}
                                                    </td>
                                                    <td>{{ $patient->payments->sum('amount') -  ( $patient->collections->sum('amount') + $patient->collections->sum('discount')) }}</td>
                                                </tr>

                                            @endif

                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>


                            </div>
                            <!-- /.card-body -->

                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
