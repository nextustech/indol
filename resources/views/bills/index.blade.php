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
                                <h5 class="m-0">Branches</h5>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table card-table table-vcenter text-nowrap table-primary">
                                            <thead  class="bg-primary text-white">
                                            <tr >
                                                <th class="text-white">Invoice No.</th>
                                                <th class="text-white">Patient</th>
                                                <th class="text-white">Invoice Date</th>
                                                <th class="text-white">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @foreach( $invoices as $inv)
                                                <tr>
                                                    <td>
                                                            <?php
                                                            $date = new DateTime($inv->created_at);
                                                            ?>
                                                        DIPC-{{ $inv->invoiceNo.$date->format('m/y') }}
                                                    </td>
                                                    <td>
                                                        @if($inv->patient)
                                                            {{ $inv->patient->name }}
                                                        @endif
                                                    </td>
                                                        <?php
                                                        $dt = new DateTime($inv->created_at);
                                                        ?>
                                                    <td>{{ $dt->format('d/m/y')  }}</td>
                                                    <td>
                                                        <a href="{{ route('invoices.show', $inv->id) }}" target="_blank" class="btn btn-success btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @can('deleteInvoice')
                                                       
                                                      {{ Html()->form('DELETE')->route('invoices.destroy', $inv->id)->style('display:inline')->open() }}      
                                                      <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                       {{ html()->form()->close() }}
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $invoices->links() }}
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

