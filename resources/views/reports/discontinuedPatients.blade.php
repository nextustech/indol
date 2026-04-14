@extends('layouts.backend')
@section('page-css')
    <link rel="stylesheet" href="{{ url('backend/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ url('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ url('backend/css/adminlte.min.css') }}">

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
                                <h5 class="m-0">Search Discontinued Patients</h5>
                            </div>

                            {{ Html()->form('GET')->route('discontinued')->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Branch</label>
                                            <select class="form-control" name="branchFilter">
                                                <option value="">All Branches</option>
                                                @foreach( $branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id  ? 'selected':'' }}>
                                                        {{ $branch->branchName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Date range -->
                                        <div class="form-group">
                                            <label>Date range:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                  </span>
                                                </div>
                                                <input type="text" class="form-control float-right" name="dateFilter" id="reservation">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-block btn-primary">Search</button>
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
                                <h5 class="m-0">Discontinued Patients Details </h5>
                            </div>

                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Patient Name</th>
                                        <th>Mobile</th>
                                        <th>Last Attended</th>
                                      	<th>Last Call</th>
                                      	<th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($patients)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $patients as $patient )
                                            <tr>
                                                <td>{{ ($patients->perPage() * ($patients->currentPage() - 1)) + $loop->iteration }}.</td>

                                                <td>
                                                    <a href="{{ route('patients.show',$patient->id) }}">
                                                        {{ $patient->name }}
                                                    </a>
                                                </td>

                                                <td> {{ $patient->mobile }} </td>
                                                <td> {{ $patient->last_attended }} </td>
                                              <?php
                                             // use \App\Models\Patient;
                                              $p = \App\Models\Patient::find($patient->id)
                                              ?>
												<td> @if($p->calls->count('call_at') > 0 ) {{ $p->calls->max('call_at') }} ( {{ $p->calls->count('call_at') }} ) @endif </td>
												<td> 
                                                    <a href="{{ route('getCreateCall',$patient->id)}}" target="_blank" >
                                                        <button type="button" class="btn btn-outline-warning"><i class="fas fa-phone"></i></button>
                                                    </a>
                                                  	<a href="{{ route('getPatientCalls',$patient->id)}}">
                                                       <button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i></button>
                                                 	</a>
                                              	</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                                <br>
                                {!! $patients->withQueryString()->links('pagination::bootstrap-5') !!}
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
@section('page-js')
    <script src="{{ url('backend/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ url('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ url('backend/js/adminlte.min.js') }}"></script>

    <script>
        $(function () {
            // //Initialize Select2 Elements
            // $('.select2').select2()
            //
            // //Initialize Select2 Elements
            // $('.select2bs4').select2({
            //     theme: 'bootstrap4'
            // })


            //Date range picker
            $('#reservation').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            })
            //Date range picker with time picker
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
    </script>
@endsection
