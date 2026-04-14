@extends('layouts.backend')
@section('page-css')
    <link rel="stylesheet" href="{{ url('backend/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ url('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ url('backend/css/adminlte.min.css') }}">

@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row  d-print-none">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Custom Day Report</h5>
                            </div>

                            {{ Html()->form('GET')->route('customDailyReport')->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Branch</label>
                                            <select class="form-control select2" multiple="multiple"  required name="branchFilter[]">
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
                                            <label>Select Date</label>
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" required autocomplete="off" name="dateFilter" class="form-control datetimepicker-input" data-target="#reservationdate" data-toggle="datetimepicker"/>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-block btn-primary">Get Report</button>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
            @if(isset($dateFilter))
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Today's Branch Collection @ ( {{ $dateFilter }} )</h5>
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
                                                    <?php
                                                    $source = $collection->collectionDate;
                                                    $collectionDate = new DateTime($source);
                                                    ?>

                                                <td> {{ $collectionDate->format(" j M y") }}</td>
                                                <td> {{ $collection->amount }}</td>

                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Total Amount </th>
                                            <th ><b>{{ $collections->sum('amount') }}</b> </th>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

                        </div>
                    </div>
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">


                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                    @foreach( $paymentModes->chunk(3) as $paymentModesChunk )
                                        <tr>
                                            @foreach( $paymentModesChunk as $paymentMode )
                                                <td class="text-bold">{{ $paymentMode->name }} - ₹.{{ $paymentMode->collections->sum('amount') }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </thead>
                                </table>
                            </div>
                            <!-- /.card-body -->

                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
                @if(count($refunds)>0)
                <div class="row">
                    <div class="col-lg-12 print-none">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Today's Branch Refund  @ ( {{ $dateFilter }} )</h5>
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
                                    @if(count($refunds)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $refunds as $collection )
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $collection->branch->branchName }}</td>
                                                <td> {{ $collection->patient->name }} </td>
                                                <td> {{ $collection->mode->name }} </td>
                                                <td> {{ $collection->serviceType->name }} </td>
                                                <td> {{ $collection->collectionDate }}</td>
                                                <td> {{ $collection->refund }}</td>

                                            </tr>
                                        @endforeach

                                        <tr>
                                            <th colspan="6">Total Refunded Amount </th>
                                            <th ><b>{{ $refunds->sum('refund') }}</b> </th>
                                        </tr>

                                    @endif
                                    </tbody>
                                </table>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                    @foreach( $paymentModes->chunk(3) as $paymentModesChunk )
                                        <tr>
                                            @foreach( $paymentModesChunk as $paymentMode )
                                                <td class="text-bold">{{ $paymentMode->name }} - ₹.{{ $paymentMode->collections->sum('refund') }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </thead>
                                </table>
                                <!-- /.card-body -->

                            </div>
                            <!-- /.card-body -->

                        </div>
                    </div>
                </div>
              @endif
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">All Expenses  @ ( {{ $dateFilter }} )</h5>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Date</th>
                                        <th>Expense Title</th>
                                        <th>Category</th>
                                        <th>Mode</th>
                                        <th>Amount</th>
                                      
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($expenses)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $expenses as $expense )
                                            <tr>
                                                <td>{{ $i++ }}</td>

                                                <td>                                                        <?php
                                                                                                                $source = $expense->date;
                                                                                                                $date = new DateTime($source);
                                                                                                                ?>
                                                    {{ $date->format(" j F y") }}
                                                </td>
                                                <td> {{ $expense->title }} </td>
                                                <td> {{ $expense->ecat->name }} </td>
                                                <td> {{ $expense->mode->name }} </td>
                                                <td> {{ $expense->amount }} </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr>
                                        <th colspan="5">Total Amount </th>
                                        <th ><b>{{ $expenses->sum('amount') }}</b> </th>
                                        <th ></th>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="col-lg-12">



                                <table class="table table-sm table-bordered">
                                    <thead>
                                    @foreach( $expenseModes->chunk(3) as $expenseModesChunk )
                                        <tr>
                                            @foreach( $expenseModesChunk as $expenseMode )
                                                <td class="text-bold">{{ $expenseMode->name }} - .{{ $expenseMode->expenses->sum('amount') }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </thead>
                                </table>
                                <!-- /.card-body -->

                            </div>

                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->

                @include('home.branchNetCash')
                <div class="row d-print-none" bis_skin_checked="1">
                    <div class="col-md-12" bis_skin_checked="1">
                        <button onclick="window.print()" class="btn btn-block btn-primary">Print this page</button>

                    </div>
                </div>
            @endif
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
@section('page-js')
    <script src="{{ url('backend/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ url('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ url('backend/js/adminlte.min.js') }}"></script>

    <script>
        $(function () {

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'DD/MM/yyyy'
            });
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection

