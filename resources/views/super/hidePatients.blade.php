@extends('layouts.backend')
@section('page-css')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ url('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

@endsection
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
                                <h5 class="m-0">Hide Patients</h5>
                            </div>

                            {{ Html()->form('POST')->route('listPatientsResult')->open() }}
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
                            {{ Html()->form('POST')->route('hidePatientsList')->open() }}
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Reg Date</th>
                                        <th>Patient ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Diagnosis</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($patients)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $patients as $patient )
                                            <tr>
                                                <td>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="checkboxPrimary{{ $patient->id }}" name="patient_id[]" value="{{ $patient->id }}">
                                                        <label for="checkboxPrimary{{ $patient->id }}">
                                                        </label>
                                                    </div>
                                                </td>
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
                                                <td></td>

                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-block btn-primary">Submit</button>
                            </div>
                            {{ Html()->form()->close() }}
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
