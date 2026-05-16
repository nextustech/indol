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
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="m-0">Branches</h5>
                                <a href="{{ route('branches.trash') }}" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> View Trash
                                </a>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                @include('partials.bulk-actions')

                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all" onclick="toggleSelectAll(this)"></th>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>address</th>
                                        <th>Branch Phone</th>
                                        <th>Branch Email</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($branches)>0)
                                    <?php $i = 1; ?>
                                        @foreach( $branches as $branche )
                                            <tr>
                                                <td><input type="checkbox" class="bulk-checkbox" value="{{ $branche->id }}" onchange="updateBulkBar()"></td>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $branche->branchName }}</td>
                                                <td> {{ $branche->address }} </td>
                                                <td> {{ $branche->branchPhone }} </td>
                                                <td> {{ $branche->branchEmail }} </td>
                                                <td>
                                                    @can('edit-branch')
                                                    <a href="{{ route('branches.edit',$branche->id)}}">
                                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-user-edit"></i></button>
                                                    </a>
                                                    @endcan
                                                    @can('delete-branch')
                                                    {{ Html()->form('DELETE')->route('branches.destroy', $branche->id)->style('display:inline')->open() }}
                                                    <button type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i>
                                                    </button>
                                                    {{ html()->form()->close() }}
                                                    @endcan

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

