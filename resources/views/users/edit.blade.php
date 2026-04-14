@extends('layouts.backend')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Edit User</h5>
                            </div>

                            {{ Html()->form('PUT')->route('users.update', $user)->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    {{ html()->model($user)->text('name')->class('form-control') }}
                                    <!--
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Full Name">
                                        -->
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>

                                    {{ html()->model($user)->email('email')->class('form-control') }}
                                    <!--
                                    <input type="text" name="email" class="form-control" id="email" placeholder="Enter email">
                                    -->
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    {{ html()->model($user)->text('username')->class('form-control') }}
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" name="password" class="form-control" id="password" placeholder="Enter password">
                                    @error('password') <span class="text-danger">{{ $message }} <span>

                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="roles">Roles</label>

                                    <select name="roles[]" id="roles" class="form-control" multiple>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role )
                                            <option value="{{ $role }}"
                                            {{ in_array($role, $user->roles->pluck('name','name')->all()) ? 'selected':'' }}
                                            >{{ $role }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Branch</label>
                                    <select name="branches[]" id="branch" class="form-control" multiple>
                                        @foreach ( $branches as $branch )
                                            <option value="{{ $branch->id }}"
                                                {{ in_array($branch->branchName, $user->branches->pluck('branchName','branchName')->all()) ? 'selected':'' }}
                                            >{{ $branch->branchName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
