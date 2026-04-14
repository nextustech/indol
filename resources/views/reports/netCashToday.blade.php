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
                                <h5 class="m-0">Today's Branch Collection</h5>
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
                                                <td> {{ $collection->collectionDate }}</td>
                                                <td> {{ $collection->amount }}</td>

                                            </tr>
                                        @endforeach
                                    @endif
                                             <tr>
                                                <td></td>
                                                <td></td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <th colspan="6">Total Amount</th>
                                                <th ><b>{{ $collections->sum('amount') }}</b> </th>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">All Expenses</h5>
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
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($todayExps)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $todayExps as $expense )
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
                                                <td>
                                                    <a href="{{ route('expenses.edit',$expense->id)}}">
                                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-user-edit"></i></button>
                                                    </a>
                                                    {{ Html()->form('DELETE')->route('expenses.destroy', $expense->id)->style('display:inline')->open() }}
                                                    <button type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i>
                                                    </button>
                                                    {{ html()->form()->close() }}

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                                                                   <tr>
                                                <td></td>
                                                <td></td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <th colspan="5">Total Amount</th>
                                                <th ><b>{{ $todayExps->sum('amount') }}</b> </th>
                                              <th ><b></b> </th>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->

                              <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Today's Net Cash</h5>
                            </div>

                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Total Collection</th>
                                        <th>Total Refund</th>
                                        <th>Total Expense</th>
                                        <th>Net Cash Today</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                            <tr>
                                              <td><b>{{ $collections->sum('amount') }}</b></td>
                                                <td><b> {{ $todayCashRefund }} </b></td>
                                                <td><b> {{ $todayExps->sum('amount') }} </b></td>
                                                <td><b> {{ $collections->sum('amount') - ( $todayCashRefund + $todayExps->sum('amount') )}}</b> </td>

                                            </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
              <div class="row">
                    <div class="col-md-12">
                      <button onclick="window.print()" class="btn btn-block btn-primary">Print this page</button>
                       
                    </div>
              </div><br/>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
