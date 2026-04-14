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
                                <h5 class="m-0">Add Expense Category</h5>
                            </div>

                            {{ Html()->form('PUT')->route('expenses.update',$expense)->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <select class="form-control select2" name="branch_id" data-placeholder="Choose Branch">
                                                <option value=""> Select Branch</option>
                                                @foreach( $branches as $branch)

                                                    <option value="{{ $branch->id }}" {{ $branch->id == $expense->branch_id  ? 'selected':'' }}>
                                                        {{ $branch->branchName }}
                                                    </option>


                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <input type="date" class="form-control fc-datepicker" name="date" value="{{ Carbon\Carbon::parse($expense->date)->format('Y-m-d'); }}" placeholder="MM/DD/YYYY" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="title" value="{{ $expense->title }}" placeholder="Enter Expense Title Here">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="amount" value="{{ $expense->amount }}" placeholder="Enter Amount" autocomplete="off">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="form-control select2" name="mode_id" data-placeholder=" Select Payment Mode">
                                                <option value="" selected> Select Payment Mode </option>
                                                @foreach( $modes as $mode)
                                                    <option value="{{ $mode->id }}"  {{ $mode->id == $expense->mode_id  ? 'selected':'' }}> {{ $mode->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control select2" name="ecat_id" data-placeholder=" Select Category ">
                                                <option value="" selected> Select Category </option>
                                                @foreach( $ecats as $ecat)
                                                    <option value="{{ $ecat->id }}"  {{ $ecat->id == $expense->ecat_id  ? 'selected':'' }}> {{ $ecat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="detail" rows="3" placeholder="Write details here (if Any ) ...">{{ $expense->detail }}</textarea>
                                        </div>


                                    </div>

                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-block btn-primary">Update Expense</button>
                            </div>
                            {{ html()->form()->close() }}
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
