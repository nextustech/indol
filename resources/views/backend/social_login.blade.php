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
                            <h5 class="m-0">Social Login Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10 col-xs-12">

                                    {{ Form::open(['route' => 'save_settings', 'class' => 'form-horizontal', 'files' => true]) }}


                                    <div class="form-group row {{ $errors->has('fb_app_id') ? 'has-error' : '' }}">
                                        <label for="fb_app_id" class="col-sm-4 control-label">Facebook App Id</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="fb_app_id"
                                                value="{{ old('fb_app_id') ? old('fb_app_id') : get_option('fb_app_id') }}"
                                                name="fb_app_id" placeholder="Site Name">
                                            {!! $errors->has('fb_app_id') ? '<p class="help-block">' . $errors->first('fb_app_id') . '</p>' : '' !!}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('fb_app_secret') ? 'has-error' : '' }}">
                                        <label for="fb_app_secret" class="col-sm-4 control-label">Facebook App
                                            Secret</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="fb_app_secret"
                                                value="{{ old('fb_app_secret') ? old('fb_app_secret') : get_option('fb_app_secret') }}"
                                                name="fb_app_secret" placeholder="Site Title">
                                            {!! $errors->has('fb_app_secret') ? '<p class="help-block">' . $errors->first('fb_app_secret') . '</p>' : '' !!}
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('google_client_id') ? 'has-error' : '' }}">
                                        <label for="google_client_id" class="col-sm-4 control-label">Google Client
                                            Id</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="google_client_id"
                                                value="{{ old('google_client_id') ? old('google_client_id') : get_option('google_client_id') }}"
                                                name="google_client_id" placeholder="Site Name">
                                            {!! $errors->has('google_client_id')
                                                ? '<p class="help-block">' . $errors->first('google_client_id') . '</p>'
                                                : '' !!}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('google_client_secret') ? 'has-error' : '' }}">
                                        <label for="google_client_secret" class="col-sm-4 control-label">Google Client
                                            Secret</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="google_client_secret"
                                                value="{{ old('google_client_secret') ? old('google_client_secret') : get_option('google_client_secret') }}"
                                                name="google_client_secret" placeholder="Site Title">
                                            {!! $errors->has('google_client_secret')
                                                ? '<p class="help-block">' . $errors->first('google_client_secret') . '</p>'
                                                : '' !!}
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('twitter_consumer_key') ? 'has-error' : '' }}">
                                        <label for="twitter_consumer_key" class="col-sm-4 control-label">Twitter Consumer
                                            Key</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="twitter_consumer_key"
                                                value="{{ old('twitter_consumer_key') ? old('twitter_consumer_key') : get_option('twitter_consumer_key') }}"
                                                name="twitter_consumer_key" placeholder="Site Name">
                                            {!! $errors->has('twitter_consumer_key')
                                                ? '<p class="help-block">' . $errors->first('twitter_consumer_key') . '</p>'
                                                : '' !!}
                                        </div>
                                    </div>

                                    <div
                                        class="form-group row {{ $errors->has('twitter_consumer_secret') ? 'has-error' : '' }}">
                                        <label for="twitter_consumer_secret" class="col-sm-4 control-label">Twitter Consumer
                                            Secret</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="twitter_consumer_secret"
                                                value="{{ old('twitter_consumer_secret') ? old('twitter_consumer_secret') : get_option('twitter_consumer_secret') }}"
                                                name="twitter_consumer_secret" placeholder="Site Title">
                                            {!! $errors->has('twitter_consumer_secret')
                                                ? '<p class="help-block">' . $errors->first('twitter_consumer_secret') . '</p>'
                                                : '' !!}
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="form-group row">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <button type="submit" id="settings_save_btn" class="btn btn-primary">Save
                                                Settings</button>
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
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="checkbox"], input[type="radio"]').click(function() {
                var input_name = $(this).attr('name');
                var input_value = 0;
                if ($(this).prop('checked')) {
                    input_value = $(this).val();
                }
                $.ajax({
                    url: '{{ route('save_settings') }}',
                    type: "POST",
                    data: {
                        [input_name]: input_value,
                        '_token': '{{ csrf_token() }}'
                    },
                });
            });

            $('input[name="date_format"]').click(function() {
                $('#date_format_custom').val($(this).val());
            });
            $('input[name="time_format"]').click(function() {
                $('#time_format_custom').val($(this).val());
            });

            /**
             * Send settings option value to server
             */
            $('#settings_save_btn').click(function(e) {
                e.preventDefault();

                var this_btn = $(this);
                this_btn.attr('disabled', 'disabled');

                var form_data = this_btn.closest('form').serialize();
                $.ajax({
                    url: '{{ route('save_settings') }}',
                    type: "POST",
                    data: form_data,
                    success: function(data) {
                        this_btn.removeAttr('disabled');
                        if (data.success == 1) {
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        } else {
                            toastr.error(data.msg, '@lang('app.error')', toastr_options);
                        }
                    }
                });
            });
        });
    </script>
@endsection
