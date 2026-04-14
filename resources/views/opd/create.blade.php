@extends('layouts.backend')
@section('page-css')
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <style type="text/css">
        .old{display: none;
            width: 100%;
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
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Add Patient</h5>
                                <div class="card-tools">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#new" data-toggle="tab">New Patient</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Old Patient</a></li>
                                  </ul>
                                </div>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="tab-content">
                                    <div class="active tab-pane" id="new">
                                        {{ Html()->form('POST')->route('opdStore')->open() }}
                                        @include('opd.new')
                                        <button type="submit" class="btn btn-block btn-primary">Register Patient</button>

                                        {{ html()->form()->close() }}
                                    </div>
                                    <div class="tab-pane" id="timeline">
                                        {{ Html()->form('POST')->route('opdOld')->open() }}
                                        @include('opd.old')
                                        <button type="submit" class="btn btn-block btn-primary">Submit</button>
                                        {{ html()->form()->close() }}
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
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
@section('page-js')

    <script>
        $('form').on('submit', function () {
            $(this).find('button[type="submit"]').prop('disabled', true);
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function(){
            $('input[type="radio"]').click(function(){
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".box").not(targetBox).hide();
                $(targetBox).show();
            });
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#schedule').click(function(){
                var inputValue = $(this).attr("value");
                $("." + inputValue).toggle(this.checked);
            });
        });
        $(document).ready(function(){
            $('#schedule2').click(function(){
                var inputValue = $(this).attr("value");
                $("." + inputValue).toggle(this.checked);
            });
        });
        $(document).ready(function(){
            $( ".datepicker" ).datepicker({
                dateFormat: "yy-mm-dd"
            });        });

        $(document).ready(function() {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            $('#datepicker1').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: true,
                startDate: today,
                endDate: end,
                autoclose: true
            });
            $('#datepicker2').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: true,
                startDate: today,
                endDate: end,
                autoclose: true
            });

            $('#datepicker1,#datepicker2').datepicker('setDate', today);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#serviceType').select2({
                placeholder: 'Search user or enter phone number',
                tags: true, // allow custom input
                ajax: {
                    url: '{{ route("check.service") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function(guest) {
                                return {
                                    id: guest.id,
                                    text: `${guest.name} (Rs ${guest.amount}) ( Days- ${guest.days})`,
                                    serviceTitle: guest.name,
                                    age: guest.amount,
                                    phone: guest.days,
                                };
                            })
                        };
                    },
                    cache: true
                },
                createTag: function(params) {
                    return {
                        id: params.term,
                        text: params.term,
                        isNew: true
                    };
                }
            });

            $('#serviceType').on('select2:select', function(e) {
                const data = e.params.data;

                if (data.age) {
                    // Data from user table
                    $('#serviceTitle').val(data.serviceTitle);
                    $('#amount').val(data.age);
                    $('#days').val(data.phone);

                } else {
                    // Free-form entry (probably a phone number)
                    $('#serviceTitle').val('');
                    $('#amount').val('');
                    $('#days').val('');

                }
            });
        });
    </script>
@endsection
