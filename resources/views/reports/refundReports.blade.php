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
                                <h5 class="m-0">Refund Reports</h5>
                            </div>

                            {{ Html()->form('GET')->route('refundReport')->open() }}
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
                                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id  ? 'selected':'' }}>
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
                                                    <option value="{{ $serviceType->id }}" {{ old('service_type_id') == $serviceType->id  ? 'selected':'' }}>
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
                                                    <option value="{{ $mode->id }}" {{ old('mode_id') == $mode->id  ? 'selected':'' }}>
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
                                                <option value="today">Today</option>
                                                <option value="yesterday">Yesterday</option>
                                                <option value="this_week">This Week</option>
                                                <option value="last_week">Last Week</option>
                                                <option value="this_month">This Month</option>
                                                <option value="last_month">Last Month</option>
                                                <option value="this_year">This Year</option>
                                                <option value="last_year">Last Year</option>
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
                                <h5 class="m-0">All Users</h5>
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
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($collections)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $collections as $collection )
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $collection->branch->branchName }}</td>
                                                <td>
                                                    <a href="{{ route('patients.show',$collection->patient) }}">
                                                        {{ $collection->patient->name }}
                                                    </a>
                                                </td>

                                                <td> {{ $collection->mode->name }} </td>
                                                <td> {{ $collection->serviceType->name }} </td>
                                                <td> {{ $collection->refundDate }}</td>
                                                <td> {{ $collection->refund }}</td>

                                            </tr>
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
