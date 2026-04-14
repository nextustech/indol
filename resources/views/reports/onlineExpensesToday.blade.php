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
                                <h5 class="m-0">Today's Online Expenses</h5>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Date</th>
                                        <th>Expense Title</th>
                                        <th>Category</th>
                                        <th>Mode</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($todayOnlineExps)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $todayOnlineExps as $expense )
                                            <tr>
                                                <td>{{ $i++ }}</td>

                                                <td>                                                        <?php
                                                                                                                $source = $expense->date;
                                                                                                                $date = new DateTime($source);
                                                                                                                ?>
                                                    {{ $date->format(" j F y") }}
                                                </td>
                                                <td> {{ $expense->title }} </td>
                                                <td> {{ $expense->ecat->name }} </td>
                                                <td> {{ $expense->mode->name }} </td>
                                                <td> {{ $expense->amount }} </td>
                                                <td>
                                                    <a href="{{ route('expenses.edit',$expense->id)}}">
                                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-user-edit"></i></button>
                                                    </a>
                                                    {{ Html()->form('DELETE')->route('expenses.destroy', $expense->id)->style('display:inline')->open() }}
                                                    <button type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i>
                                                    </button>
                                                    {{ html()->form()->close() }}

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
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
