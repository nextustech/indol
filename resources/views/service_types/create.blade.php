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
                                <h5 class="m-0">Add Service Type</h5>
                            </div>

                            {{ Html()->form('POST')->route('servicetypes.store')->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Service name">


                                        </div>
                                        <!-- Amount -->
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" name="amount" class="form-control" step="0.01" value="{{ old('amount') }}" required>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <!-- Days -->
                                        <div class="form-group">
                                            <label>Days</label>
                                            <input type="number" name="days" class="form-control" value="{{ old('days') }}" required>
                                        </div>

                                        <!-- Discount -->
                                        <div class="form-group">
                                            <label>Discount</label>
                                            <input type="number" name="discount" class="form-control" step="0.01" value="{{ old('discount') }}">
                                        </div>


                                    </div>


                                </div>
                                <div class="form-group">
                                    <label for="note">note</label>
                                    <input type="text" name="note" class="form-control" id="note" placeholder="Enter note">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
