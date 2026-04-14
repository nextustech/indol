@extends('layouts.backend')
@section('page-css')

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <style>
        .ui-datepicker{ z-index:9999!important; }
    </style>
    <style type="text/css">
        .old{display: none;
            width: 500px;
        }
        .bx{
            display: none;
            margin-top: 20px;
        }
    </style>


@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{ url('backend/img/user4-128x128.jpg') }}"
                                         alt="User profile picture">
                                </div>
                                <li class="btn-group mb-2 mt-2">
                                    <button class="btn btn-outline-danger btn-sm">
                                        Reg. :
                                        <?php
                                        $source = $patient->date;
                                        $date = new DateTime($source);
                                        ?>
                                        {{ $date->format(" j M, y") }}

                                    </button>
                                    <a href="{{ route('patients.edit',$patient) }}" class="btn btn-outline-danger btn-sm">
                                        <i class="fa fa-pen"></i>
                                    </a>&nbsp;
                                    {{ Html()->form('DELETE')->route('patients.destroy',$patient->id)->open() }}
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick='
                                                        if(confirm("Are you sure?") == false) {
                                                            return false;
                                                        } else {
                                                            //
                                                        }'>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {{ html()->form()->close() }}

                                </li>

                                <h3 class="profile-username text-center">{{ $patient->name }}</h3>

                                <p class="text-muted text-center">
                                    @if($patient->gender == 1)
                                        M
                                    @elseif($patient->gender == 2)
                                        F
                                    @else
                                        N.A
                                    @endif
                                    &nbsp; {{ $patient->age  }} Yrs
                                </p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Mobile : </b> <a class="float-right">{{ $patient->mobile }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Patient ID :</b> <a class="float-right">GPC - {{ $patient->id }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="float-right">
                                            @foreach( $patient->branches as $branch)
                                                {{ $branch->branchName }}
                                            @endforeach

                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('getChangeBranch',$patient->id) }}" class="btn btn-block btn-outline-info">
                                            Change Branch
                                        </a>
                                    </li>
                                </ul>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fas fa-book mr-1"></i> Diagnosis</strong>

                                <p class="text-muted">
                                    {{ $patient->diagnosis }}
                                </p>

                                <hr>

                                <strong><i class="fas fa-pencil-alt mr-1"></i> Reffered By</strong>

                                <p class="text-muted">{{ $patient->ref_by }}</p>

                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                                <p class="text-muted">
                                    {{ $patient->address }}
                                </p>

                                <hr>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        @foreach($patient->calls as $call)
                        <div class="card card-primary card-outline">


                            <div class="card-body" style="padding: .25rem; font-size:12px;">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <table class="table table-bordered table-hover" >
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Response</th>
                                            </tr>
                                            <tr>
                                                <th>{{ $call->call_at }}</th>
                                                <th>{{ $call->response }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan ="2">Details</td>
                                            </tr>
                                            <tr>
                                                <td colspan ="2">{{ $call->detail }}</td>
                                            </tr>
                                            @if($call->note != null)
                                            <tr>
                                                <td colspan ="2">Notes</td>
                                            </tr>
                                            <tr>
                                                <td colspan ="2">{{ $call->note }}</td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->

                        </div>
                        <!-- /.card -->
                        @endforeach
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('page-js')

    <script src="{{ url('be/assets/js/select2.js') }}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#schedule').click(function(){
                var inputValue = $(this).attr("value");
                $("." + inputValue).toggle(this.checked);
            });
        });
    </script>


@endsection
