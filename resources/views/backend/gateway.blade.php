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
                                <div class="form-group row">
                                    <label for="payuMoneySecret" class="col-sm-4 control-label">RazorPay Enable /Disable</label>
                                    <div class="custom-control custom-switch  col-sm-8">
                                        <input type="checkbox" class="custom-control-input"  name="RazorPay" id="customSwitch" {{ get_option('RazorPay')=='on' ? 'checked': '' }}>
                                        <label class="custom-control-label"for="customSwitch">RazorPay</label>
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('razorPayKey')? 'has-error':'' }}">
                                    <label for="razorPayKey" class="col-sm-4 control-label">Razor Pay Key</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="site_name" value="{{ old('razorPayKey')? old('razorPayKey') : get_option('razorPayKey') }}" name="razorPayKey" placeholder="Razorpay Ket">
                                        {!! $errors->has('razorPayKey')? '<p class="help-block">'.$errors->first('razorPayKey').'</p>':'' !!}
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('razorPaySecret')? 'has-error':'' }}">
                                    <label for="razorPaySecret" class="col-sm-4 control-label">Razor Pay Secret</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="razorPaySecret" value="{{ old('razorPaySecret')? old('razorPaySecret') : get_option('razorPaySecret') }}" name="razorPaySecret" placeholder="Razor Pay Secret">
                                        {!! $errors->has('razorPaySecret')? '<p class="help-block">'.$errors->first('razorPaySecret').'</p>':'' !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="payuMoneySecret" class="col-sm-4 control-label">PayuMoney Enable /Disable</label>
                                    <div class="custom-control custom-switch  col-sm-8">
                                        <input type="checkbox" class="custom-control-input"  name="payuMoney" id="customSwitch1" {{ get_option('payuMoney')=='on' ? 'checked': '' }} >
                                        <label class="custom-control-label"for="customSwitch1">PayuMoney</label>
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('payuMoneyKey')? 'has-error':'' }}">
                                    <label for="payuMoneyKey" class="col-sm-4 control-label">PayuMoney Key</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="site_name" value="{{ old('payuMoneyKey')? old('payuMoneyKey') : get_option('payuMoneyKey') }}" name="payuMoneyKey" placeholder="PayuMoney Key">
                                        {!! $errors->has('payuMoneyKey')? '<p class="help-block">'.$errors->first('payuMoneyKey').'</p>':'' !!}
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('payuMoneySecret')? 'has-error':'' }}">
                                    <label for="payuMoneySecret" class="col-sm-4 control-label">PayuMoney Salt</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="payuMoneySecret" value="{{ old('payuMoneySecret')? old('payuMoneySecret') : get_option('payuMoneySecret') }}" name="payuMoneySecret" placeholder="PayuMoney Secret">
                                        {!! $errors->has('payuMoneySecret')? '<p class="help-block">'.$errors->first('payuMoneySecret').'</p>':'' !!}
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