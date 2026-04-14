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

                            {{ Html()->form('GET')->route('collectionReport')->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="row">
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Service Type</label>
                                            <select class="form-control" name="serviceTypeFilter">
                                                <option value="">All Services</option>
                                                @foreach( $serviceTypes as $serviceType)
                                                    <option value="{{ $serviceType->id }}" {{ $serviceTypeFilter == $serviceType->id  ? 'selected':'' }}>
                                                        {{ $serviceType->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Payment Mode</label>
                                            <select class="form-control" name="modeFilter">
                                                <option value="">All Modes</option>
                                                @foreach( $modes as $mode)
                                                    <option value="{{ $mode->id }}" {{ $modeFilter == $mode->id  ? 'selected':'' }}>
                                                        {{ $mode->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                <h5 class="m-0">Collection Details </h5>
                            </div>

                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Branch</th>
                                        <th>Patient</th>
                                        <th>Mode</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Amount </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($collections)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $collections as $collection )
                                            @if($collection->refund == NULL)
                                            <tr>
                                                <?php

                                                    $collectionDate = new DateTime($collection->collectionDate);
                                                ?>
                                                <td>{{ ($collections->perPage() * ($collections->currentPage() - 1)) + $loop->iteration }}.</td>
                                                <td>{{ $collection->branch->branchName }}</td>
                                                <td>
                                                    <a href="{{ route('patients.show',$collection->patient) }}">
                                                        {{ $collection->patient->name }}
                                                    </a>
                                                </td>

                                                <td> {{ $collection->mode->name }} </td>
                                                <td> {{ $collection->serviceType->name }} </td>
                                                <td>@if($collection->collectionDate)
                                                    {{ $collectionDate->format("d-m-Y")  }}
                                                    @endif
                                                </td>
                                                <td> {{ $collection->amount }}</td>

                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    <tr>
                                        <th colspan="6">Total Amount (This Page )</th>
                                        <th ><b>{{ $collections->sum('amount') }}</b> </th>
                                    </tr>
                                    <tr>
                                        <th colspan="6">Grand Total Amount</th>
                                        <th ><b>{{ $totalAmount }}</b> </th>
                                    </tr>

                                    </tbody>
                                </table>
                                <br>
                                {!! $collections->withQueryString()->links('pagination::bootstrap-5') !!}

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
