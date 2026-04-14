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
                                <h5 class="m-0">Refund</h5>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                {{--                                {{ Form::model($payment, array('route' => array('updateDate', $payment->id), 'method' => 'PATCH', 'files' => true)) }}--}}
                                {{ Html()->form('POST')->route('storeRefund')->open() }}
                                <input name="payment_id" value="{{ $payment->id }}" hidden>
                                <input name="patient_id" value="{{ $patient->id }}" hidden>
                                <input name="branch_id" value="{{ $branch_id }}" hidden>
                                <input name="service_type_id" value="{{ $payment->service_type_id }}" hidden>
                                <input name="amount" value="" hidden>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="Patient : {{ $patient->name }}" placeholder="Enter Package Name Here">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="Amount To Be Paid Rs.{{ $payment->amount }}" placeholder="Enter Amount Here">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="Paid Amount : {{ $collections->sum('amount') }}"  placeholder="Payment Amount">
                                        </div>
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="collectionDate" value="{{ old('collectionDate') }}" placeholder="MM/DD/YYYY" autocomplete="off">
                                        </div>
                                        <?php
                                        $modes = \App\Models\Mode::all();
                                        ?>
                                        <div class="form-group">
                                            <select class="form-control select2" name="mode_id" data-placeholder="Choose Payment Method" style="width: 100%" required>
                                                <option value="" selected> Select Payment Mode </option>
                                                @foreach( $modes as $mode)
                                                    <option value="{{ $mode->id }}"> {{ $mode->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="@if($payment){{ $payment->title }}@else N.A @endif" placeholder="Enter Duration in Days Here">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" value="Package Duration :@if($payment){{ $payment->duration }} @else N.A @endif Days" placeholder="Enter Duration in Days Here">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="Discount : {{ $collections->sum('discount') }}" placeholder="Discount if any">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="refund" placeholder="Enter Amount Refunded">
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                                </div>
                                {{ Html()->form()->close() }}


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

