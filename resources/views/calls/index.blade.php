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
                                <h5 class="m-0">Call Detail</h5>
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
                                        <th>Patient</th>
                                        <th>Mobile</th>
                                        <th>Call At</th>
                                        <th>Response</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($calls)>0)
                                            <?php $i = 1; ?>
                                        @foreach( $calls as $call )
                                            <tr>
                                                <td>{{ ($calls->perPage() * ($calls->currentPage() - 1)) + $loop->iteration }}.</td>
                                                <td>{{ $call->patient->name }}</td>
                                                <td> {{ $call->mobile }} </td>
                                                <td> {{ $call->call_at }} </td>
                                                <td> {{ $call->response }} </td>
                                                <td>


                                                       {{-- <a href="{{ route('calls.edit',$call->id)}}">
                                                            <button type="button" class="btn btn-outline-primary"><i class="fas fa-user-edit"></i></button>
                                                        </a> --}}


                                                        {{ Html()->form('DELETE')->route('calls.destroy', $call->id)->style('display:inline')->open() }}
                                                        <button type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i>
                                                        </button>
                                                        {{ html()->form()->close() }}


                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <br>
                                {!! $calls->withQueryString()->links('pagination::bootstrap-5') !!}
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

