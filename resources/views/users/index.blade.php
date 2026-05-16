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
                                <h5 class="m-0">All Users</h5>
                                <a href="{{ route('users.trash') }}" class="btn btn-sm btn-danger">
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
                                        <th>E-mail</th>
                                        <th>Username</th>
                                        <th>Roles</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($users)>0)
                                    <?php $i = 1; ?>
                                        @foreach( $users as $user )
                                            <tr>
                                                <td><input type="checkbox" class="bulk-checkbox" value="{{ $user->id }}" onchange="updateBulkBar()"></td>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td> {{ $user->email }} </td>
                                                <td> {{ $user->username }} </td>
                                                <td>
                                                    @if(!empty($user->getRoleNames()))
                                                        @foreach ($user->getRoleNames() as $roleName)
                                                            <label class="badge badge-warning">{{ $roleName }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('users.edit',$user->id)}}">
                                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-user-edit"></i></button>
                                                    </a>
                                                    {{ Html()->form('DELETE')->route('users.destroy', $user->id)->style('display:inline')->open() }}
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

