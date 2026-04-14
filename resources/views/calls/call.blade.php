@extends('layouts.backend')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content mt-2">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Patient Call Form</h3>
                    </div>
                    <!-- form start -->
                    <form role="form">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="patientName">Patient Name</label>
                                        <input type="text" class="form-control" id="patientName" placeholder="Enter patient name">
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" placeholder="Enter mobile number">
                                    </div>


                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="callAt">Call At</label>
                                        <input type="datetime-local" class="form-control" id="callAt">
                                    </div>
                                    <div class="form-group">
                                        <label for="response">Response</label>
                                        <select class="form-control" id="response">
                                            <option value="">Select response</option>
                                            <option value="interested">Interested</option>
                                            <option value="not_interested">Not Interested</option>
                                            <option value="follow_up">Need Follow Up</option>
                                            <option value="no_answer">No Answer</option>
                                            <option value="no_answer">Not Reachable</option>
                                        </select>
                                    </div>


                                </div>
                            </div>
                            <div class="form-group">
                                <label for="detail">Detail</label>
                                <textarea class="form-control" id="detail" rows="3" placeholder="Enter details..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea class="form-control" id="note" rows="2" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
