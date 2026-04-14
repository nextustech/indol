@extends('layouts.backend')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content mt-2">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Collection</h3>
                        </div>
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
                                    {{ Html()->form('PATCH')->route('collection.update', $collection)->open() }}

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                          @can('BackDateEntry')
                                                            <div class="form-group">
                                                                <input type="date" class="form-control" name="collectionDate" value="{{ Carbon\Carbon::parse($collection->collectionDate)->format('Y-m-d'); }}"  placeholder="" autocomplete="off">
                                                            </div>
                                                          @endcan
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" value="{{ $collection->patient->name }}" placeholder="Enter Name Here">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="{{ $collection->payment->amount }}" placeholder="Enter Amount Here">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="amount" value="{{ $collection->amount }}" required placeholder="{{ $collection->amount }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="mode_id" data-placeholder="Choose Payment Method" style="width: 100%" required>
                                                            <?php
                                                            $modes = \App\Models\Mode::all();
                                                            ?>
                                                            @foreach( $modes as $mode)
                                                                <option value="{{ $mode->id }}" {{ $mode->id == $collection->mode_id  ? 'selected':'' }}> {{ $mode->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="@if ($collection->payment->title) {{ $collection->payment->title }} @endif" placeholder="Enter Duration in Days Here">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="Package Duration :@if ($collection->payment->duration) {{ $collection->payment->duration }}  @endif  Days" placeholder="Enter Duration in Days Here">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="discount" placeholder="Discount if any">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="paymentNote" placeholder="Payment's Note if any">
                                                    </div>
                                                </div>

                                            </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Update Payment</button>
                                    </div>
                                    {{ Html()->form()->close() }}

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