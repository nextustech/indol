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
                                <h5 class="m-0">Search Patients By Registration Date</h5>
                            </div>

                            {{ Html()->form('POST')->route('searchPatientByRegDate')->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="date" class="form-control fc-datepicker" name="from" value="{{ old('from') }}" autocomplete="off" placeholder="MM/DD/YYYY">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="date" class="form-control fc-datepicker" name="upto" value="{{ old('upto') }}" autocomplete="off" placeholder="MM/DD/YYYY">
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
                                <h5 class="m-0">Patient List</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Reg Date</th>
                                        <th>Patient ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Diagnosis</th>
                                        <th>Branch</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($patients)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $patients as $patient )
                                            <tr>

                                                <td>
                                                        <?php
                                                        $source = $patient->date;
                                                        $date = new DateTime($source);
                                                        ?>
                                                    {{ $date->format('d/m/y') }}
                                                </td>
                                                <td>
                                                        <?php
                                                        $source = $patient->created_at;
                                                        $date = new DateTime($patient->created_at);
                                                        ?>
                                                    GPC-{{ $patient->patientId.'-'.$date->format('m/y') }}
                                                </td>
                                                <td> <a href="{{ route('patients.show', $patient->id ) }}"> {{ ucfirst($patient->name) }} </a>
                                                    ( {{ $patient->age }} , @if($patient->gender == 1) {{'M' }} @elseif($patient->gender == 2){{'F '}}@endif )
                                                </td>
                                                <td> {{ $patient->mobile }}   </td>
                                                <td> {{ $patient->diagnosis }}</td>
                                                <td>
                                                    @foreach( $patient->branches as $branch )
                                                        {{ $branch->branchName }}
                                                    @endforeach
                                                </td>

                                                <td>
                                                  @can('show-PatientProfile')
                                                    <a href="{{ route('patients.show',$patient->id)}}">
                                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i></button>
                                                    </a>
                                                  @endcan
                                                  @can('edit-PatientProfile')
                                                    <a href="{{ route('patients.edit',$patient->id)}}">
                                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-user-edit"></i></button>
                                                    </a>
                                                  @endcan
                                                  @can('delete-PatientProfile')
                                                    {{ Html()->form('DELETE')->route('patients.destroy', $patient->id)->style('display:inline')->open() }}
                                                    <button type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i>
                                                    </button>
                                                    {{ html()->form()->close() }}
												 @endcan
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
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
