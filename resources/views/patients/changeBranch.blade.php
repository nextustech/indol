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
                                <h5 class="m-0">Change Patient Branch</h5>
                            </div>

                            {{ Html()->form('POST')->route('changeBranch',$patient)->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-sm">
                                            <tr>

                                                <td>Name :- <a href="{{ route('patients.show',$patient) }}" data-toggle="tooltip" data-placement="top" title="{{ $patient->diagnosis }}">
                                                        {{ ucfirst($patient->name) }} </a> ( {{ $patient->age }} @if($patient->gender == 1) M  @else  F @endif )
                                                </td>
                                                <td>Phone No. {{ $patient->mobile }} </td>

                                                <td>Branch:-
                                                    @foreach( $patient->branches as $branch )
                                                        {{ $branch->branchName }}
                                                    @endforeach
                                                </td>

                                            </tr>
                                            <tr>
                                                <?php
                                                $source = $patient->date;
                                                $regDate = new DateTime($source);
                                                ?>

                                                <td>Reg.Date - {{ $regDate->format(" j M, y") }}</td>
                                                <td>GPC - {{ $patient->id }}</td>


                                                <td>

                                                </td>

                                            </tr>
                                        </table>
                                      <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                      <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                        <div class="form-group">
                                            <label>Select Branch</label>
                                            <select class="form-control" required name="branch_id">
                                                <option value="">All Branches</option>
                                                @foreach( $branches as $branch)
                                                    <option value="{{ $branch->id }}">
                                                        {{ $branch->branchName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Branch Transfer Type</label>
                                            <select class="form-control" required name="type">
                                                <option value="1" > Only Change Branch </option>
                                                <option value="2" > Change Branch With Active Package </option>
                                                <option value="3" > Change Branch Completely </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-block btn-primary">Change Branch</button>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>

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
@endsection

