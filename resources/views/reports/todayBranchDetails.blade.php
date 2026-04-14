@extends('layouts.backend')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content mt-2">
            <div class="container-fluid">
              {{--
                @include('reports.infoBoxes')
                @foreach( $serviceTypes->chunk(3) as $serviceTypeChunk )
                    <div class="row d-print-none">

                        @if(count($serviceTypeChunk) < 5)
                                <?php
                                if(!(count($serviceTypeChunk))){
                                    $dby = 1;
                                }else{
                                    $dby = count($serviceTypeChunk);
                                }

                                $mdNo = 12 / $dby; ?>
                        @endif
                        @foreach( $serviceTypeChunk as $serviceType )
                            <div class="col-md-{{$mdNo}}">
                                <a href="{{ route('serviceDetail',$serviceType->id) }}">
                                    <div class="callout callout-success">
                                        <h5>{{ $serviceType->name }} ( {{ $serviceType->collections->count() }} )</h5>
                                        <p style="color: darkgreen">₹.{{ $serviceType->collections->sum('amount') }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                @endforeach
		--}}
                <div class="row">
                    <div class="col-lg-12 print-none">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Today's <i><b> {{ $branch->branchName }} </b></i>Collection @ ( {{ $dateTm }} )</h5>
                            </div>

                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Patient</th>
                                        <th>Mode</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                      	<th>By User</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($collections)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $collections as $collection )
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                
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
												<td>{{ $collection->user->name }}</td>
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
                <div class="row">
                    <div class="col-lg-12 print-none">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Today's Branch Refund  @ ( {{ $dateTm }} )</h5>
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
                                        @foreach( $refunds as $collection )
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $collection->branch->branchName }}</td>
                                                <td> {{ $collection->patient->name }} </td>
                                                <td> {{ $collection->mode->name }} </td>
                                                <td> {{ $collection->serviceType->name }} </td>
                                                    <?php
                                                    $source = $collection->refundDate;
                                                    $refundDate = new DateTime($source);
                                                    ?>

                                                <td> {{ $refundDate->format(" j M y") }}</td>
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
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">All Expenses  @ ( {{ $dateTm }} )</h5>
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
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
