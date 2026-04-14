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
                                            @if( $patient->payments->sum('amount') >  ( $patient->collections->sum('amount') + $patient->collections->sum('discount')))
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

