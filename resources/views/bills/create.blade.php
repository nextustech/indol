@extends('layouts.backend')
@section('page-css')
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
        }
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            margin-bottom: 0.66em;
            font-family: 'Open Sans', sans-serif;
            font-weight: 900;
            line-height: 1.1;
            color: inherit;
        }
        .card-body{
            color: #000000;

        }

        b, strong {
            font-weight: bolder;
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

                        <div class="card">
                            <?php
                            // $date = new DateTime($invoice->created_at);
                            ?>


                            <div class="card-body">
{{--                                {!! Form::open(array('url' => 'invoices','files' => true)) !!}--}}
                                {{ Html()->form('POST')->route('invoices.store')->open() }}
                                <div class="row text-right">
                                    <div class="col-sm-3">
                                        <br><br>

                                    </div>
                                    <div class="col-sm-6 text-center">

                                        <strong> - Physiotherapy Bill -</strong>
                                    </div>
                                    <div class="col-sm-3 text-right">
                                    </div>
                                </div>


                                <div class="dropdown-divider"></div>
                                <div class="card-body pl-0 pr-0">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>Branch</span><br>
                                            <select class="form-control select2" name="branch_id" data-placeholder="Choose Branch">
                                                @foreach( $branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id  ? 'selected':'' }}>
                                                        <h2><b> {{ $branch->branchName }} </b></h2>
                                                      
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-sm-6 text-right">
                                            <span>Payment Date</span><br>
                                            <div class="row">
                                                <div class="col-sm-6"></div>
                                                <div class="col-sm-6">
                                                    <input type="date" class="form-control fc-datepicker" name="date" value="{{ old('date') }}" placeholder="MM/DD/YYYY" autocomplete="off">

                                                </div>
                                            </div>

                                            <strong></strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="row pt-2">
                                    <div class="col-lg-6 col-sm-6">
                                        <p class="h4">{{ $patient->name }}</p>
                                        <address>
                                            {{ $patient->address }}
                                        </address>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 text-right">
                                    </div>
                                </div>
                                <div class="table-responsive push">
                                    <table class="table table-bordered table-hover">
                                        <tr class="">
                                            <th class="text-center "></th>
                                            <th>Services</th>
                                            <th class="text-center">Qnt</th>
                                            <th class="text-right">Unit</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                        <?php $i = 1; ?>
                                        <?php $sum = 0; ?>
                                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                        @foreach($patient->payments as $pay)
                                                                                  <?php
                                            $totalDiscount = \App\Models\Collection::where('payment_id',$pay->id)->sum('discount');
                                            $totalPayable = $pay->amount - $totalDiscount;
                                            ?>
                                            <tr>
                                                <td class="text-center"><input type="checkbox" name="package[]" value="{{ $pay->id }}"></td>
                                                <td>
                                                    <p class="font-w600 mb-1">@if($pay->pakage_id) {{ $pay->pakage->name }} @else {{ $pay->title }} @endif</p>
                                                    <div class="text-muted">
                                                        @if($pay->pakage_id) {{ $pay->pakage->timePeriod }} @else {{ $pay->duration }}  Sittings @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">@if($pay->pakage_id) {{ $pay->pakage->timePeriod }} @else {{ $pay->duration }} @endif</td>
                                                <td class="text-right"></td>
                                                <td class="text-right">{{ $totalPayable }}</td>
                                            </tr>
                                                <?php // $sum = $sum+$bill->amount ?>
                                        @endforeach
                                        <tr>
                                            <td colspan="5" rowspan="2" class="text-right">
                                                <button type="submit" class="btn btn-warning d-print-none"><i class="si si-printer"></i> Create Invoice</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                {{ Html()->form()->close() }}
                                <p class="text-muted text-center"> Thank you very much for giving chance to serve you. We look forward to serve with you again!</p>
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
