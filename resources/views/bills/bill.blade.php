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
                            <div class="card-header">
                                <?php
                                $date = new DateTime($invoice->date);
                                ?>

                                <h3 class="card-title">#INV-WNR-{{ $invoice->invoiceNo.$date->format('m/y') }}</h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <span></span><br>
                                      @if($invoice->branch->id == 3 )
                                      <strong>MSME : UDYAM-RJ-06-0032661</strong>
                                      
                                      @else
                                        <strong>MSME : UP01D044850</strong>
                                      @endif
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <br>
                                    </div>
                                    <div class="col-sm-4 text-right">
                                        <span>Helpline No.: {{ $invoice->branch->branchPhone }}</span><br>
                                        <strong>E-mail : {{ $invoice->branch->branchEmail }}</strong>
                                    </div>
                                </div>
                                <div class="row text-right">
                                    <div class="col-sm-4">
                            <span>
							<img src="{{ url($invoice->branch->logo) }}" alt="">

							</span><br><br>

                                    </div>
                                    <div class="col-sm-5 text-center">
                                        <h3>{{ $invoice->branch->branchName }}</h3>
                                      @if($invoice->branch->id != 3)
                                        <strong>An ISO 9001:2015 Certified Clinic</strong><br>
                                      @endif
                                        <strong>{{ $invoice->branch->slogan }}</strong>
                                    </div>
                                    <div class="col-sm-3 text-right">
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>
                                <div class="card-body pl-0 pr-0">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>Inovice No.</span><br>
                                            <strong>#INV-WNR-{{ $date->format('my').'/'.$invoice->invoiceNo }}</strong>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <span>Invoice Date</span><br>
                                            <strong>{{ $date->format('M d,Y') }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="row pt-2">
                                    <div class="col-lg-6 col-sm-6">
                                        <p class="h4">{{ $invoice->branch->branchName }}</p>
                                        <address>
                                            {{ $invoice->branch->address }}<br>
                                        </address>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 text-right">
                                        <p class="h4">{{ $invoice->patient->name }} ( {{ $invoice->patient->age }} )</p>
                                        <address>
                                            {{ $invoice->patient->address }}
                                        </address>
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
                                        @foreach($invoice->bills as $bill)
                                            <tr>
                                                <td class="text-center">&nbsp; @if($bill->packageName) {{ $i++ }} @endif</td>
                                                <td>
                                                    <p class="font-w600 mb-1">{{ $bill->packageName }}</p>
                                                        <?php
                                                        $invDate = new DateTime($bill->date);
                                                        if($bill->sittingsPerDay != NULL){
                                                            $noOfSittings = $bill->duration * $bill->sittingsPerDay;
                                                        }else{
                                                            $noOfSittings = $bill->duration;
                                                        }
                                                        ?>

                                                    <div class="text-muted">{{ $noOfSittings }} sittings  @if($bill->date) ( {{ $invDate->format('M d,Y') }} ) @endif </div>
                                                </td>
                                                <td class="text-center">{{ $noOfSittings }}</td>
                                                <td class="text-right">@if($bill->duration && $bill->amount ) {{ round((($bill->amount)/( $noOfSittings )), 2) }} @endif</td>
                                                <td class="text-right">{{ $bill->amount }}</td>
                                            </tr>
                                                <?php $sum = $sum+$bill->amount ?>
                                        @endforeach
                                        <tr>
                                            <td colspan="4" class="font-w600 text-right">Subtotal</td>
                                            <td class="text-right"><i class="side-menu__icon fa fa-inr"></i>{{ $sum }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="font-weight-bold text-uppercase text-right">Total Amount</td>
                                            <td class="font-weight-bold text-right"><i class="side-menu__icon fa fa-inr"></i>{{ $sum }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">
                                                <button type="button" class="btn btn-warning d-print-none" onClick="javascript:window.print();"><i class="si si-printer"></i> Print Invoice</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <p class="text-muted text-center">Thank you very much for giving chance to serve you. We look forward to serve with you again!</p>
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
