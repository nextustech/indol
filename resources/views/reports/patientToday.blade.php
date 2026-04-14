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
                                    @if(count($newPatients)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $newPatients as $patient )
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

