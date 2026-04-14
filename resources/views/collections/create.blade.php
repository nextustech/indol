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
                                <h5 class="m-0">Collection</h5>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                <div class="card-body p-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @include ('errors.list')
                                            @if(Session::has('message'))
                                                <div class="alert alert-success text-center">{{ session('message') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="panel panel-primary">

                                        <div class="panel-body tabs-menu-body">

                                            {{ Html()->form('POST')->route('collection.store')->open() }}
                                            <input name="payment_id" value="{{ $payment->id }}" hidden>
                                            <input name="service_type_id" value="{{ $payment->service_type_id }}" hidden>
                                            <input name="branch_id" value="{{ $payment->branch_id }}" hidden>
                                            <input name="patient_id" value="{{ $patient->id }}" hidden>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                          @can('BackDateEntry')
                                                            <div class="form-group">
                                                                <input type="date" class="form-control" name="collectionDate"  placeholder="MM/DD/YYYY" autocomplete="off">
                                                            </div>
														  @else
                                                           <div class="form-group">
                                                                <input type="text" class="form-control" name="collectionDate" value="{{ $todaysDate }}" readonly placeholder="MM/DD/YYYY" autocomplete="off">
                                                            </div>
                                                          @endcan
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" value="{{ $patient->name }}" placeholder="Enter Package Name Here">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="Amount To Be Paid Rs.{{ $payment->amount }} Paid {{ $payment->collections->sum('amount') }}" placeholder="Enter Amount Here">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="amount" required placeholder="Remaining Amount {{ $payment->amount - $payment->collections->sum('amount') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="mode_id" data-placeholder="Choose Payment Method" style="width: 100%" required>
                                                            <?php
                                                            $modes = \App\Models\Mode::all();
                                                            ?>
                                                            @foreach( $modes as $mode)
                                                                <option value="{{ $mode->id }}"> {{ $mode->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="@if ($payment->title) {{ $payment->title }} @endif" placeholder="Enter Duration in Days Here">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="Package Duration :@if ($payment->duration) {{ $payment->duration }}  @endif  Days" placeholder="Enter Duration in Days Here">
                                                    </div>
                                                  @can('discount')
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="discount" placeholder="Discount if any">
                                                    </div>
                                                  @else
                                                     <div class="form-group">
                                                        <input type="text" class="form-control" name="discount" readonly placeholder="Discount if any">
                                                    </div>
                                                  @endcan
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="paymentNote" placeholder="Payment's Note if any">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-footer text-right">
                                                <button type="submit" class="btn btn-primary">Deposit Payment</button>
                                            </div>
                                            {!! Html()->form('POST')->close() !!}

                                        </div>
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

