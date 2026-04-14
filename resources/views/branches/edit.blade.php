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
                                <h5 class="m-0">Edit Branch Details</h5>
                            </div>

                            {{ Html()->form('PUT')->route('branches.update', $branch)->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                <div class="form-group">
                                    <label for="branchName">Branch Name</label>
                                    {{ html()->model($branch)->text('branchName')->class('form-control') }}
                                </div>
                                <div class="form-group row {{ $errors->has('logo') ? 'has-error' : '' }}">
                                    <label for="site_name" class="col-sm-4 control-label">Site Logo</label>
                                    <div class="col-sm-8">
                                        <div id="holder"

                                             style="margin-top:15px;max-height:100px;">
                                            @if ($branch->logo)
                                            <img src="{{ $branch->logo }}" style="height: 5rem;">
                                            @endif
                                        </div>
                                        <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                       class="btn btn-primary">
                                                        <i class="fa fa-picture-o"></i> Change
                                                    </a>
                                                </span>

                                            <input type="text" class="form-control" id="thumbnail"
                                                   value="{{ old('logo') ? old('logo') : get_option('logo') }}"
                                                   name="logo" placeholder="Site Logo" hidden>
                                            {!! $errors->has('logo') ? '<p class="help-block">' . $errors->first('logo') . '</p>' : '' !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">address</label>
                                    {{ html()->model($branch)->text('address')->class('form-control') }}
                                </div>

                                <div class="form-group">
                                    <label for="branchPhone">Branch Phone</label>
                                    {{ html()->model($branch)->text('branchPhone')->class('form-control') }}
                                </div>
                                <div class="form-group">
                                    <label for="branchEmail">Branch Email</label>
                                    {{ html()->model($branch)->text('branchEmail')->class('form-control') }}
                                </div>
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Tax Name</label>
                                            {{ html()->model($branch)->text('taxName')->class('form-control') }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="IGST">IGST %</label>
                                            {{ html()->model($branch)->text('IGST')->class('form-control') }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="CGST">CGST %</label>
                                            {{ html()->model($branch)->text('CGST')->class('form-control') }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="SGST">SGST %</label>
                                            {{ html()->model($branch)->text('SGST')->class('form-control') }}

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="taxNo">Branch GST No</label>
                                            {{ html()->model($branch)->text('taxNo')->class('form-control') }}
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="taxNo">Branch Short Code</label>
                                            {{ html()->model($branch)->text('shortCode')->class('form-control') }}
                                        </div>

                                    </div>
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
@section('page-js')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>

@endsection
