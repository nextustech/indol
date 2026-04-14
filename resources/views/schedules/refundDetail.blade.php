@extends('layouts.backend')
@section('page-css')
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <style type="text/css">
        .tg  {border-style:solid;border-width:1px;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 5px;overflow:hidden;word-break:normal;border-color:black;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;overflow:hidden;word-break:normal;border-color:black;}
        .tg .tg-w9sc{font-size:13px;border-color:inherit;text-align:center}
        .tg .tg-rils{font-size:20px;border-color:inherit;text-align:center}
        .tg .tg-kiyi{font-weight:bold;border-color:inherit;text-align:left}
        .tg .tg-oi3e{font-size:12px;border-color:inherit;text-align:right}
        .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
        .tg .tg-uys7{border-color:inherit;text-align:center}
        .tg .tg-3pun{font-size:12px;border-color:inherit;text-align:left}
        .tg .tg-quj4{border-color:inherit;text-align:right}
        .tg .tg-xldj{border-color:inherit;text-align:left}
        .tg .tg-xld2{border-color:inherit;text-align:right}
        .tg .tg-8bpo{font-size:28px;font-family:"Times New Roman", Times, serif !important;;border-color:inherit;}
        .tg .tg-1plf{font-size:12px;border-color:inherit;text-align:center}
        .tg .tg-wwri{font-size:20px;border-color:inherit;text-align:center;background-color:#000000}
        .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
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
                                <h5 class="m-0">Refund Details</h5>
                            </div>

                            <div class="card-body">
                                <div class="row tg">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span></span><br>
                                                <strong>MSME : </strong>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <h4>Schedule</h4><br>
                                            </div>
                                            <div class="col-sm-4 text-right">
                                                <span>PH:8559-826-826,8306-826-827</span><br>
                                                <strong>E-mail : manojsingh2884@gmail.com</strong>
                                            </div>
                                        </div>
                                        <div class="row text-right">
                                            <div class="col-sm-4">
                                                <span><img src="{{ url('images/logo.png') }}" alt=""></span><br><br>

                                            </div>
                                            <div class="col-sm-5 text-center">
                                                <h3>Gauri Physiotherapy Clinic</h3>
                                                <strong>An ISO 9001:2015 Certified Clinic</strong><br>
                                                <strong>A Complete Neuro. Rehabilitation Center</strong>
                                            </div>
                                            <div class="col-sm-3 text-right">

                                                <b>Package Amount : Rs.{{ $payment->amount }}</b>
                                                <b>Amount/visit : Rs.{{ $payment->amount/$visits }}</b>
                                            </div>
                                        </div>
                                        <div class="inner-all">
                                            <div class="table-responsive">
                                                <table class="table card-table table-vcenter border text-nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Sitting No.</th>
                                                        <th>Attended At</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    ?>

                                                    @foreach($schedules as $schedule)
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                $source = $schedule->sittingDate;
                                                                $date = new DateTime($source);
                                                                ?>
                                                                {{ $date->format(" j F, Y") }}
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-warning btn-sm">
                                                                    {{ $schedule->title }}
                                                                </button>


                                                            </td>
                                                            <td>
                                                                <?php
                                                                $date2 = new DateTime($schedule->attendedAt);
                                                                ?>
                                                                @if($schedule->attendedAt)
                                                                    <button class="btn btn-success btn-sm">
                                                                        {{  $date2->format(" j F, Y, g:i a") }}
                                                                    </button>

                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(!$schedule->attendedAt)
                                                                @else
                                                                    Attended
                                                                @endif
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <br>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <button onclick="javascript:window.print();" class="btn btn-danger d-print-none" type="button">Print </button>

                                    </div>
                                </div>

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

