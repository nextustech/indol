@extends('layouts.mbk')
@section('content')

        <!-- Main content -->
<div class="content">
    <div class="container-fluid mb-3">
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">General Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 col-xs-12">

                                {{ Form::open(['route'=>'save_settings','class' => 'form-horizontal', 'files' => true]) }}


                                <div class="form-group row {{ $errors->has('vendor_registration_amount')? 'has-error':'' }}">
                                    <label for="vendor_registration_amount" class="col-sm-4 control-label">Vendor Registration Amount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="site_name" value="{{ old('vendor_registration_amount')? old('vendor_registration_amount') : get_option('vendor_registration_amount') }}" name="vendor_registration_amount" placeholder="Vendor Registration Amount">
                                        {!! $errors->has('vendor_registration_amount')? '<p class="help-block">'.$errors->first('vendor_registration_amount').'</p>':'' !!}
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('vendor_registration_discount')? 'has-error':'' }}">
                                    <label for="vendor_registration_discount" class="col-sm-4 control-label">Vendor Registration Discount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="site_name" value="{{ old('vendor_registration_discount')? old('vendor_registration_discount') : get_option('vendor_registration_discount') }}" name="vendor_registration_discount" placeholder="Vendor Registration Amount">
                                        {!! $errors->has('vendor_registration_discount')? '<p class="help-block">'.$errors->first('vendor_registration_discount').'</p>':'' !!}
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('user_registration_amount')? 'has-error':'' }}">
                                    <label for="user_registration_amount" class="col-sm-4 control-label">User Registration Amount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="user_registration_amount" value="{{ old('user_registration_amount')? old('user_registration_amount') : get_option('user_registration_amount') }}" name="user_registration_amount" placeholder="User Registration Amount">
                                        {!! $errors->has('user_registration_amount')? '<p class="help-block">'.$errors->first('user_registration_amount').'</p>':'' !!}
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('user_registration_discount')? 'has-error':'' }}">
                                    <label for="user_registration_discount" class="col-sm-4 control-label">User Registration Amount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="user_registration_discount" value="{{ old('user_registration_discount')? old('user_registration_discount') : get_option('user_registration_discount') }}" name="user_registration_discount" placeholder="User Registration Amount">
                                        {!! $errors->has('user_registration_discount')? '<p class="help-block">'.$errors->first('user_registration_discount').'</p>':'' !!}
                                    </div>
                                </div>


                                <div class="form-group row {{ $errors->has('userPageImage')? 'has-error':'' }}">
                                    <label for="site_name" class="col-sm-4 control-label">User Registration Page Image</label>
                                    <div class="col-sm-8">
                                        <img id="holder" @if(get_option('userPageImage')) src="{{ get_option('userPageImage') }}" @endif style="margin-top:15px;max-height:100px;">
                                        <div class="input-group">
                                           <span class="input-group-btn">
                                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                 <i class="fa fa-picture-o"></i> Change
                                             </a>
                                           </span>

                                            <input type="text" class="form-control" id="thumbnail" value="{{ old('userPageImage')? old('userPageImage') : get_option('userPageImage') }}" name="userPageImage" placeholder="User Page Image" hidden>
                                            {!! $errors->has('userPageImage')? '<p class="help-block">'.$errors->first('userPageImage').'</p>':'' !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('jobPageImage')? 'has-error':'' }}">
                                    <label for="site_name" class="col-sm-4 control-label">Job Registration Page Image</label>
                                    <div class="col-sm-8">
                                        <img id="holder-1" @if(get_option('jobPageImage'))src="{{ get_option('jobPageImage') }}" @endif style="margin-top:15px;max-height:100px;">
                                        <div class="input-group">
                                           <span class="input-group-btn">
                                             <a id="jobPageImage" data-input="thumbnail-1" data-preview="holder-1" class="btn btn-primary">
                                                 <i class="fa fa-picture-o"></i> Change
                                             </a>
                                           </span>

                                            <input type="text" class="form-control" id="thumbnail-1" value="{{ old('jobPageImage')? old('jobPageImage') : get_option('jobPageImage') }}" name="jobPageImage" placeholder="User Page Image" hidden>
                                            {!! $errors->has('logo')? '<p class="help-block">'.$errors->first('logo').'</p>':'' !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('loanPageImage')? 'has-error':'' }}">
                                    <label for="site_name" class="col-sm-4 control-label">Loan Registration Page Image</label>
                                    <div class="col-sm-8">
                                        <img id="holder-2" @if(get_option('loanPageImage'))src="{{ get_option('loanPageImage') }}" @endif style="margin-top:15px;max-height:100px;">
                                        <div class="input-group">
                                           <span class="input-group-btn">
                                             <a id="loanPageImage" data-input="thumbnail-2" data-preview="holder-2" class="btn btn-primary">
                                                 <i class="fa fa-picture-o"></i> Change
                                             </a>
                                           </span>

                                            <input type="text" class="form-control" id="thumbnail-2" value="{{ old('loanPageImage')? old('loanPageImage') : get_option('loanPageImage') }}" name="loanPageImage" placeholder="User Page Image" hidden>
                                            {!! $errors->has('logo')? '<p class="help-block">'.$errors->first('logo').'</p>':'' !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('coursePageImage')? 'has-error':'' }}">
                                    <label for="site_name" class="col-sm-4 control-label">Course Registration Page Image</label>
                                    <div class="col-sm-8">
                                        <img id="holder-3" @if(get_option('coursePageImage'))src="{{ get_option('coursePageImage') }}" @endif style="margin-top:15px;max-height:100px;">
                                        <div class="input-group">
                                           <span class="input-group-btn">
                                             <a id="coursePageImage" data-input="thumbnail-3" data-preview="holder-3" class="btn btn-primary">
                                                 <i class="fa fa-picture-o"></i> Change
                                             </a>
                                           </span>

                                            <input type="text" class="form-control" id="thumbnail-3" value="{{ old('coursePageImage')? old('coursePageImage') : get_option('coursePageImage') }}" name="coursePageImage" placeholder="User Page Image" hidden>
                                            {!! $errors->has('logo')? '<p class="help-block">'.$errors->first('logo').'</p>':'' !!}
                                        </div>
                                    </div>
                                </div>




                                <hr />
                                <div class="form-group row">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <button type="submit" id="settings_save_btn" class="btn btn-primary">Save</button>
                                    </div>
                                </div>

                                {{ Form::close() }}
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@endsection

@section('page-js')
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        $('#lfm').filemanager('image');
        $('#jobPageImage').filemanager('image');
        $('#loanPageImage').filemanager('image');
        $('#coursePageImage').filemanager('image');
    </script>

    <script>
        $(document).ready(function(){
            $('input[type="checkbox"], input[type="radio"]').click(function(){
                var input_name = $(this).attr('name');
                var input_value = 0;
                if ($(this).prop('checked')){
                    input_value = $(this).val();
                }
                $.ajax({
                    url : '{{ route('save_settings') }}',
                    type: "POST",
                    data: { [input_name]: input_value, '_token': '{{ csrf_token() }}' },
        });
        });

        $('input[name="date_format"]').click(function(){
            $('#date_format_custom').val($(this).val());
        });
        $('input[name="time_format"]').click(function(){
            $('#time_format_custom').val($(this).val());
        });

        /**
         * Send settings option value to server
         */
        $('#settings_save_btn').click(function(e){
            e.preventDefault();

            var this_btn = $(this);
            this_btn.attr('disabled', 'disabled');

            var form_data = this_btn.closest('form').serialize();
            $.ajax({
                url : '{{ route('save_settings') }}',
                type: "POST",
                data: form_data,
                success : function (data) {
                    this_btn.removeAttr('disabled');
                    if (data.success == 1){
                        toastr.success(data.msg, '@lang('app.success')', toastr_options);
                    }else {
                        toastr.error(data.msg, '@lang('app.error')', toastr_options);
                    }
                }
            });
        });
        });
    </script>
@endsection
