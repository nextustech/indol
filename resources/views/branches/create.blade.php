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
                                <h5 class="m-0">Add Branch</h5>
                            </div>

                            {{ Html()->form('POST')->route('branches.store')->open() }}
                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                <div class="form-group">
                                    <label for="branchName">Branch Name</label>
                                    <input type="text" name="branchName" class="form-control" id="branchName" placeholder="Enter Branch Name">
                                </div>
                                <div class="form-group row {{ $errors->has('logo') ? 'has-error' : '' }}">
                                    <label for="site_name" class="col-sm-4 control-label">Site Logo</label>
                                    <div class="col-sm-8">
                                        <div id="holder"
                                             @if (get_option('logo')) src="{{ get_option('logo') }}" @endif
                                             style="margin-top:15px;max-height:100px;"></div>
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
                                    <input type="text" name="address" class="form-control" id="address" placeholder="Enter address">
                                </div>

                                <div class="form-group">
                                    <label for="branchPhone">Branch Phone</label>
                                    <input type="text" name="branchPhone" class="form-control" id="branchPhone" placeholder="Enter Branch Phone">
                                </div>
                                <div class="form-group">
                                    <label for="branchEmail">Branch Email</label>
                                    <input type="text" name="branchEmail" class="form-control" id="branchEmail" placeholder="Enter Branch Email">
                                </div>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">Tax Name</label>
                                <input type="text" class="form-control" name="taxName" id="email"
                                       value="{{ old('taxName', $setting->taxName ?? '') }}" placeholder="Enter Name of Tax">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="IGST">IGST %</label>
                                <input type="text" class="form-control" name="IGST" id="IGST"
                                       value="{{ old('IGST', $setting->IGST ?? '') }}" placeholder="IGST %">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CGST">CGST %</label>
                                <input type="text" class="form-control" name="CGST" id="CGST"
                                       value="{{ old('CGST', $setting->CGST ?? '') }}" placeholder="CGST %">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="SGST">SGST %</label>
                                <input type="text" class="form-control" name="SGST" id="SGST"
                                       value="{{ old('SGST', $setting->SGST ?? '') }}" placeholder="SGST %">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="taxNo">Branch GST No</label>
                                <input type="taxNo" class="form-control" name="taxNo" id="taxNo"
                                       value="{{ old('taxNo', $setting->taxNo ?? '') }}" placeholder="Enter Tax No">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="taxNo">Branch Short Code</label>
                                <input type="shortCode" class="form-control" name="shortCode" id="shortCode"
                                       value="{{ old('shortCode', $setting->shortCode ?? '') }}" placeholder="Enter Short Code">
                            </div>
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
