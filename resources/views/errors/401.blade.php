@extends('layouts.backend')

@section('content')

        <!-- Main content -->
    <div class="content">
        <div class="container-fluid mb-3">
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12 mt-2">
                    <div class="card card-primary card-outline">
                        <div class="card-header text-center">
                            <h5 class="m-0">You Do Not Have Required Permissions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row" style="padding-top: 80px;padding-bottom: 80px">
                                <div class="col-md-12 col-xs-12 text-center">
                                    <h3>401</h3>
                                    <h2 style="color: #9c1613">ACCESS DENIED</h2>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

@endsection

