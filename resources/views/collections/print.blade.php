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
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12"><br>
                        <div class="card ">
                            <div class="card-body">
                                <div class="row tg">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span></span><br>
                                                <strong>MSME REGISTERED</strong>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <h4>Receipt</h4><br>
                                            </div>
                                            <div class="col-sm-4 text-right">
                                                <span>PH: {{ $collection->branch->branchPhone }}</span><br>
                                                <strong>E-mail : {{ $collection->branch->branchEmail }}</strong>
                                            </div>
                                        </div>
                                        <div class="row text-right">
                                            <div class="col-sm-4">
                                                <span><img src="{{ url($collection->branch->logo) }}" alt=""></span><br><br>

                                            </div>
                                            <div class="col-sm-5 text-center">

                                                <h3>{{ $collection->branch->branchName }}</h3>
                                                <strong>{{ $collection->branch->slogan }}</strong>
                                            </div>
                                            <div class="col-sm-3 text-right">
                                            </div>
                                        </div>
                                        <div class="inner-all">
                                            <div class="table-responsive">
                                                <table class="table text-nowrap">
                                                    <tr>
                                                        <td class="tg tg-wwri" colspan="3"><span style="font-weight:bold; color:white">ADD : {{ $collection->branch->address }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-xldj">S.No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $collection->id }}</td>
                                                        <td class="tg-xldj"></td>
                                                        <td class="tg-quj4">Dated :
                                                            <?php
                                                            $source = $collection->collectionDate;
                                                            $date = new DateTime($source);
                                                            ?>
                                                            {{ $date->format("D, j F, y") }}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-xldj"><span style="font-weight:bold">Shri. / Smt. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ ucfirst($collection->patient->name) }} ({{ $collection->patient->age }})</span></td>
                                                        <td class="tg-xldj"></td>
                                                        <td class="tg-quj4">GPC-{{ $collection->patient->patientId }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-xldj"><span style="font-weight:bold">
													@if($payment->title != Null)
                                                                    {{ $payment->title }}
                                                                @endif
                                                                <?php

                                                                if($collection->payment){
                                                                    $amount = getIndianCurrency($collection->amount);
                                                                }else{
                                                                    $amount = 'N.A';
                                                                }

                                                                ?>



                                                        </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                            Total Amount : {{ $payment->amount }}/-   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  @if( $totalDiscount > 0 ) Discount : {{ $totalDiscount }}/- @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Total Payable : {{ $payment->amount - $totalDiscount }}/- 

                                                        </td>
                                                        <td class="tg-xldj">
                                                        </td>
                                                        <td class="tg-quj4">
                                                            Phone :- {{ $collection->patient->mobile }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-kiyi" colspan="2">Received With Thanks &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8377; <b>
                                                                @if($collection->amount){{ $collection->amount }} ( {{ ucfirst($amount) }} ) @else N.A @endif &nbsp;&nbsp;&nbsp;&nbsp;
                                                                @if( $totalRefund > 0 )
                                                                    Refund : &#8377;{{ $totalRefund }}
                                                                @else
                                                                    Balance Amount: &#8377;{{ ( $payment->amount - $totalCollection ) - $totalDiscount }} /-
                                                                @endif</b></td>
                                                        <td class="tg-uys7" rowspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        if($payment->perDaySittings != NULL){
                                                            $noOfSittings = $payment->duration * $payment->perDaySittings;
                                                        }else{
                                                            $noOfSittings = $payment->duration;
                                                        }

                                                        if($collection->discount){
                                                            $paymentAmount = $payment->amount - $totalDiscount;
                                                        }else{
                                                            $paymentAmount = $payment->amount;

                                                        }

                                                        ?>

                                                        <td class="tg-xldj" colspan="2">@if($payment->duration >0 ) <b>No. Of Days : </b> {{ $payment->duration }}  &nbsp;&nbsp;&nbsp;&nbsp; Amount / Day : &#8377;{{ round(( $payment->amount - $totalDiscount ) / $payment->duration , 2 ) }}/- ( {{ $payment->perDaySittings }} visits/Day ) @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-0pky"> Payment Mode - @if($collection->mode) {{ $collection->mode->name }} @endif

                                                        </td>
                                                        <td class="tg-0pky"></td>
                                                        <td class="tg-c3ow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature</td>
                                                    </tr>
                                                </table>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <br><br>
                                <div class="row tg">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span></span><br>
                                                <strong>MSME REGISTERED</strong>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <h4>Receipt</h4><br>
                                            </div>
                                            <div class="col-sm-4 text-right">
                                                <span>PH: {{ $collection->branch->branchPhone }}</span><br>
                                                <strong>E-mail : {{ $collection->branch->branchEmail }}</strong>
                                            </div>
                                        </div>
                                        <div class="row text-right">
                                            <div class="col-sm-4">
                                                <span><img src="{{ url($collection->branch->logo) }}" alt=""></span><br><br>

                                            </div>
                                            <div class="col-sm-5 text-center">

                                                <h3>{{ $collection->branch->branchName }}</h3>
                                                <strong>{{ $collection->branch->slogan }}</strong>
                                            </div>
                                            <div class="col-sm-3 text-right">
                                            </div>
                                        </div>
                                        <div class="inner-all">
                                            <div class="table-responsive">
                                                <table class="table text-nowrap">
                                                    <tr>
                                                        <td class="tg tg-wwri" colspan="3"><span style="font-weight:bold; color:white;">ADD : {{ $collection->branch->address }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-xldj">S.No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $collection->id }}</td>
                                                        <td class="tg-xldj"></td>
                                                        <td class="tg-quj4">Dated :
                                                            <?php
                                                            $source = $collection->collectionDate;
                                                            $date = new DateTime($source);
                                                            ?>
                                                            {{ $date->format("D, j F, y") }}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-xldj"><span style="font-weight:bold">Shri. / Smt. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ ucfirst($collection->patient->name) }} ({{ $collection->patient->age }})</span></td>
                                                        <td class="tg-xldj"></td>
                                                        <td class="tg-quj4">GPC-{{ $collection->patient->patientId }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-xldj"><span style="font-weight:bold">
													@if($payment->title != Null)
                                                                    {{ $payment->title }}
                                                                @endif

                                                        </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            Total Amount : {{ $payment->amount }}/-   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  @if( $totalDiscount > 0 ) Discount : {{ $totalDiscount }}/- @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Total Payable : {{ $payment->amount - $totalDiscount }}/- 
                                                        </td>
                                                        <td class="tg-xldj">
                                                        </td>
                                                        <td class="tg-quj4">
                                                            Phone :- {{ $collection->patient->mobile }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-kiyi" colspan="2">Received With Thanks &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8377; <b>
                                                                @if($collection->amount){{ $collection->amount }} ( {{ ucfirst($amount) }} ) @else N.A @endif &nbsp;&nbsp;&nbsp;&nbsp;
                                                                @if( $totalRefund > 0 )
                                                                    Refund : &#8377;{{ $totalRefund }}
                                                                @else
                                                                    Balance Amount: &#8377;{{ ( $payment->amount - $totalCollection ) - $totalDiscount }} /-
                                                                @endif</b></td>
                                                        <td class="tg-uys7" rowspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        if($payment->perDaySittings != NULL){
                                                            $noOfSittings = $payment->duration * $payment->perDaySittings;
                                                        }else{
                                                            $noOfSittings = $payment->duration;
                                                        }

                                                        if($collection->discount){
                                                            $paymentAmount = $payment->amount - $totalDiscount;
                                                        }else{
                                                            $paymentAmount = $payment->amount;

                                                        }
                                                        ?>

                                                        <td class="tg-xldj" colspan="2">@if($payment->duration >0 ) <b>No. Of Days : </b> {{ $payment->duration }}  &nbsp;&nbsp;&nbsp;&nbsp; Amount / Day :   &#8377;{{ round(( $payment->amount - $totalDiscount ) / $payment->duration , 2 ) }}/- ( {{ $payment->perDaySittings }} visits/Day ) @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-0pky"> Payment Mode - @if($collection->mode) {{ $collection->mode->name }} @endif
                                                        </td>
                                                        <td class="tg-0pky"></td>
                                                        <td class="tg-c3ow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature</td>
                                                    </tr>
                                                </table>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <br><br>
                                <div class="row tg">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span></span><br>
                                                <strong>MSME REGISTERED</strong>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <h4>Receipt</h4><br>
                                            </div>
                                            <div class="col-sm-4 text-right">
                                                <span>PH: {{ $collection->branch->branchPhone }}</span><br>
                                                <strong>E-mail : {{ $collection->branch->branchEmail }}</strong>
                                            </div>
                                        </div>
                                        <div class="row text-right">
                                            <div class="col-sm-4">
                                                <span><img src="{{ url($collection->branch->logo) }}" alt=""></span><br><br>

                                            </div>
                                            <div class="col-sm-5 text-center">

                                                <h3>{{ $collection->branch->branchName }}</h3>
                                                <strong>{{ $collection->branch->slogan }}</strong>
                                            </div>
                                            <div class="col-sm-3 text-right">
                                            </div>
                                        </div>
                                        <div class="inner-all">
                                            <div class="table-responsive">
                                                <table class="table text-nowrap">
                                                    <tr>
                                                        <td class="tg tg-wwri" colspan="3"><span style="font-weight:bold; color:white;">ADD : {{ $collection->branch->address }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-xldj">S.No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $collection->id }}</td>
                                                        <td class="tg-xldj"></td>
                                                        <td class="tg-quj4">Dated :
                                                            <?php
                                                            $source = $collection->collectionDate;
                                                            $date = new DateTime($source);
                                                            ?>
                                                            {{ $date->format("D, j F, y") }}
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-xldj"><span style="font-weight:bold">Shri. / Smt. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ ucfirst($collection->patient->name) }} ({{ $collection->patient->age }})</span></td>
                                                        <td class="tg-xldj"></td>
                                                        <td class="tg-quj4">GPC-{{ $collection->patient->patientId }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-xldj"><span style="font-weight:bold">
													@if($payment->title != Null)
                                                                    {{ $payment->title }}
                                                                @endif

                                                        </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                           Total Amount : {{ $payment->amount }}/-   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  @if( $totalDiscount > 0 ) Discount : {{ $totalDiscount }}/- @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Total Payable : {{ $payment->amount - $totalDiscount }}/- 

                                                        </td>
                                                        <td class="tg-xldj">
                                                        </td>
                                                        <td class="tg-quj4">
                                                            Phone :- {{ $collection->patient->mobile }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-kiyi" colspan="2">Received With Thanks &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8377; <b>
                                                                @if($collection->amount){{ $collection->amount }} ( {{ ucfirst($amount) }} ) @else N.A @endif &nbsp;&nbsp;&nbsp;&nbsp;
                                                                @if( $totalRefund > 0 )
                                                                    Refund : &#8377;{{ $totalRefund }}
                                                                @else
                                                                    Balance Amount: &#8377;{{ ( $payment->amount - $totalCollection ) - $totalDiscount }} /-
                                                                @endif</b></td>
                                                        <td class="tg-uys7" rowspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        if($payment->perDaySittings != NULL){
                                                            $noOfSittings = $payment->duration * $payment->perDaySittings;
                                                        }else{
                                                            $noOfSittings = $payment->duration;
                                                        }
                                                        ?>

                                                        <td class="tg-xldj" colspan="2">@if($payment->duration >0 ) <b>No. Of Days : </b> {{ $payment->duration }}  &nbsp;&nbsp;&nbsp;&nbsp; Amount / Day :   &#8377;{{ round(( $payment->amount - $totalDiscount ) / $payment->duration , 2 ) }}/- ( {{ $payment->perDaySittings }} visits/Day ) @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-0pky"> Payment Mode - @if($collection->mode) {{ $collection->mode->name }} @endif
                                                        </td>
                                                        <td class="tg-0pky"></td>
                                                        <td class="tg-c3ow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature</td>
                                                    </tr>
                                                </table>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <br>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <a href="{{ route('opd.create') }}" class="btn btn-success">
                                            Go OPD
                                        </a>
                                        <button onclick="javascript:window.print();" class="btn btn-danger d-print-none" type="button">Print </button>
                                        <a href="{{ route('patients.show',$collection->patient_id) }}" class="btn btn-success">
                                            Go To Profile
                                        </a>

                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
