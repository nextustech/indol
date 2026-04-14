@extends('layouts.backend')
@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content mt-2">
            <div class="container-fluid">
                              <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Trips</h5>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">

                                    </ul>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <!-- Filter Section -->
                                <div class="card-body">
                                    <form action="" method="GET">
                                        <div class="row">
                                            <!-- Bus Filter -->
                                            <div class="col-md-6">
                                                <label>Select Branch:</label>
                                                <select class="form-control" name="branch_id">
                                                    <option value="">All Branch</option>
                                                    @foreach($brnches as $branch)
                                                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->branchName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <!-- Date Range Button -->
                                            <div class="col-md-6">
                                                <label>Date Range:</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-default float-right w-100" id="daterange-btn">
                                                        <i class="far fa-calendar-alt"></i>
                                                        <span id="daterange-text">Select Date Range</span>
                                                        <i class="fas fa-caret-down float-right"></i>
                                                    </button>
                                                </div>

                                                <!-- Hidden inputs to submit -->
                                                <input type="hidden" id="date_from" name="date_from" value="{{ request('date_from') }}">
                                                <input type="hidden" id="date_to" name="date_to" value="{{ request('date_to') }}">

                                                <small class="text-primary" id="selected-range">
                                                    @if(request('date_from'))
                                                        Selected: {{ request('date_from') }} → {{ request('date_to') }}
                                                    @else
                                                        Selected: None
                                                    @endif
                                                </small>
                                            </div>
                                            <!-- Search Button -->
                                            <div class="col-md-6 mt-3">

                                                <button type="submit" class="btn btn-primary btn-sm btn-block">
                                                    <i class="fa fa-search"></i> Apply Filter
                                                </button>

                                            </div>
                                            <div class="col-md-6 mt-3">


                                                <a href="{{ route('patients.index') }}" class="btn btn-secondary btn-sm btn-block">
                                                    Reset
                                                </a>

                                            </div>



                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">All Patients</h5>
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
                                        <th>Patient ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Age</th>
                                        <th>Branch</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($patients)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $patients as $patient )
                                            <tr>
                                                    <?php
                                                    $source = $patient->date;
                                                    $regDate = new DateTime($source);
                                                    ?>

                                                <td>{{ $regDate->format(" j M, y") }}</td>
                                                <td>GPC - {{ $patient->id }}</td>
                                                <td><a href="{{ route('patients.show',$patient) }}" data-toggle="tooltip" data-placement="top" title="{{ $patient->diagnosis }}">
                                                        {{ ucfirst($patient->name) }} </a> ( {{ $patient->age }} @if($patient->gender == 1) M  @else  F @endif )
                                                </td>
                                                <td> {{ $patient->mobile }} </td>
                                                <td>{{ $patient->age }}</td>
                                                <td>
                                                    @foreach( $patient->branches as $branch )
                                                        {{ $branch->branchName }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{ route('patients.edit',$patient->id)}}">
                                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-user-edit"></i></button>
                                                    </a>
                                                    {{ Html()->form('DELETE')->route('patients.destroy', $patient->id)->style('display:inline')->open() }}
                                                    <button type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i>
                                                    </button>
                                                    {{ html()->form()->close() }}

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
								{!! $patients->withQueryString()->links('pagination::bootstrap-5') !!}

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
@section('page-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function () {

            $('#daterange-btn').daterangepicker(
                {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                },

                function (start, end) {
                    // Update button text
                    $('#daterange-text').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));

                    // Show selected range below
                    $('#selected-range').html("Selected: " + start.format('YYYY-MM-DD') + " → " + end.format('YYYY-MM-DD'));

                    // Set hidden inputs for Laravel
                    $('#date_from').val(start.format('YYYY-MM-DD'));
                    $('#date_to').val(end.format('YYYY-MM-DD'));
                }
            );

        });

    </script>
@endsection
