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
                                <h5 class="m-0">Edit Patient Profile</h5>
                            </div>
                            {{ Html()->form('PUT')->route('patients.update', $patient )->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">



                                        <div class="form-group">
                                            <input type="date" class="form-control fc-datepicker" name="date" value="{{ Carbon\Carbon::parse($patient->date)->format('Y-m-d'); }}" placeholder="Registration Date ( DD/MM/YYYY )" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" value="{{ $patient->name }}" id="name" placeholder="Enter Name Here">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="age" value="{{ $patient->age }}" id="age" placeholder="Enter Age Here">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="form-control select2" name="gender" data-placeholder="Choose Gender">
                                                        <option value="" selected> </option>
                                                        <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>
                                                            Male
                                                        </option>
                                                        <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>
                                                            Female
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="mobile" value="{{ $patient->mobile }}" id="mobile" placeholder="Enter Mobile No. Here">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="ref_by" value="{{ $patient->ref_by }}" placeholder="Referred By">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="diagnosis" value="{{ $patient->diagnosis }}" placeholder="Diagnosis">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="address" id="exampleFormControlTextarea2" rows="1" placeholder="Write Address here ...">{{ $patient->address }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="otherNotes" id="exampleFormControlTextarea1" rows="1" placeholder="Write Other Description ( If Any ) here ...">{{ $patient->otherNotes }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-block">Update </button>
                            </div>
                            {{ html()->form()->close() }}
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

