@extends('layouts.backend')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
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

                                    {{ Html()->form('POST')->route('save_settings')->acceptsFiles()->open() }}

                                    <div class="form-group row {{ $errors->has('site_name') ? 'has-error' : '' }}">
                                        <label for="site_name" class="col-sm-4 control-label">Site Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="site_name"
                                                value="{{ old('site_name') ? old('site_name') : get_option('site_name') }}"
                                                name="site_name" placeholder="Site Name">
                                            {!! $errors->has('site_name') ? '<p class="help-block">' . $errors->first('site_name') . '</p>' : '' !!}
                                        </div>
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

                                    <div class="form-group row {{ $errors->has('site_title') ? 'has-error' : '' }}">
                                        <label for="site_title" class="col-sm-4 control-label">Site Title</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="site_title"
                                                value="{{ old('site_title') ? old('site_title') : get_option('site_title') }}"
                                                name="site_title" placeholder="Site Title">
                                            {!! $errors->has('site_title') ? '<p class="help-block">' . $errors->first('site_title') . '</p>' : '' !!}
                                        </div>
                                    </div>


                                    <div class="form-group row {{ $errors->has('site_description') ? 'has-error' : '' }}">
                                        <label for="site_description" class="col-sm-4 control-label">Site
                                            Description</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="site_description"
                                                value="{{ old('site_description') ? old('site_description') : get_option('site_description') }}"
                                                name="site_description" placeholder="Site Description">
                                            {!! $errors->has('site_description')
                                                ? '<p class="help-block">' . $errors->first('site_description') . '</p>'
                                                : '' !!}
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('site_metas') ? 'has-error' : '' }}">
                                        <label for="site_metas" class="col-sm-4 control-label">Site Meta</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="site_metas"
                                                value="{{ old('site_metas') ? old('site_metas') : get_option('site_metas') }}"
                                                name="site_metas" placeholder="Site Meta">
                                            {!! $errors->has('site_metas') ? '<p class="help-block">' . $errors->first('site_metas') . '</p>' : '' !!}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('email_address') ? 'has-error' : '' }}">
                                        <label for="email_address" class="col-sm-4 control-label">Email Address</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="email_address"
                                                value="{{ old('email_address') ? old('email_address') : get_option('email_address') }}"
                                                name="email_address" placeholder="Email Address">
                                            {!! $errors->has('email_address') ? '<p class="help-block">' . $errors->first('email_address') . '</p>' : '' !!}
                                            <p class="text-info"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('mailchimp_apiKey') ? 'has-error' : '' }}">
                                        <label for="mailchimp_apiKey" class="col-sm-4 control-label">Mail Chimp API
                                            Key</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="mailchimp_apiKey"
                                                value="{{ old('mailchimp_apiKey') ? old('mailchimp_apiKey') : get_option('mailchimp_apiKey') }}"
                                                name="mailchimp_apiKey" placeholder="Mail Chimp API Key">
                                            {!! $errors->has('mailchimp_apiKey') ? '<p class="help-block">' . $errors->first('email_address') . '</p>' : '' !!}
                                            <p class="text-info"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('mailchimp_listId') ? 'has-error' : '' }}">
                                        <label for="mailchimp_listId" class="col-sm-4 control-label">Mail Chimp List
                                            Id</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="mailchimp_listId"
                                                value="{{ old('mailchimp_listId') ? old('mailchimp_listId') : get_option('mailchimp_listId') }}"
                                                name="mailchimp_listId" placeholder="Mail Chimp List Id">
                                            {!! $errors->has('mailchimp_listId')
                                                ? '<p class="help-block">' . $errors->first('mailchimp_listId') . '</p>'
                                                : '' !!}
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                                        <label for="phone" class="col-sm-4 control-label">Phone No.</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="phone"
                                                value="{{ old('phone') ? old('phone') : get_option('phone') }}"
                                                name="phone" placeholder="Phone No.">
                                            {!! $errors->has('phone') ? '<p class="help-block">' . $errors->first('phone') . '</p>' : '' !!}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('mobile') ? 'has-error' : '' }}">
                                        <label for="mobile" class="col-sm-4 control-label">Mobile No.</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="mobile"
                                                value="{{ old('mobile') ? old('mobile') : get_option('mobile') }}"
                                                name="mobile" placeholder="Mobile No.">
                                            {!! $errors->has('mobile') ? '<p class="help-block">' . $errors->first('mobile') . '</p>' : '' !!}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label for="email" class="col-sm-4 control-label">E-mail</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="email"
                                                value="{{ old('email') ? old('email') : get_option('email') }}"
                                                name="email" placeholder="E-mail">
                                            {!! $errors->has('email') ? '<p class="help-block">' . $errors->first('email') . '</p>' : '' !!}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('add_l_1') ? 'has-error' : '' }}">
                                        <label for="add_l_1" class="col-sm-4 control-label">Address Line 1</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="add_l_1"
                                                value="{{ old('add_l_1') ? old('add_l_1') : get_option('add_l_1') }}"
                                                name="add_l_1" placeholder="Address line 1">
                                            {!! $errors->has('add_l_1') ? '<p class="help-block">' . $errors->first('add_l_1') . '</p>' : '' !!}
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('add_l_2') ? 'has-error' : '' }}">
                                        <label for="add_l_2" class="col-sm-4 control-label">Address Line 2</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="add_l_2"
                                                value="{{ old('add_l_2') ? old('add_l_2') : get_option('add_l_2') }}"
                                                name="add_l_2" placeholder="Address Line 2">
                                            {!! $errors->has('add_l_2') ? '<p class="help-block">' . $errors->first('add_l_2') . '</p>' : '' !!}
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('add_l_3') ? 'has-error' : '' }}">
                                        <label for="add_l_3" class="col-sm-4 control-label">Address Line 3</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="add_l_3"
                                                value="{{ old('add_l_3') ? old('add_l_3') : get_option('add_l_3') }}"
                                                name="add_l_3" placeholder="Address Line 3">
                                            {!! $errors->has('add_l_3') ? '<p class="help-block">' . $errors->first('add_l_3') . '</p>' : '' !!}
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('add_l_4') ? 'has-error' : '' }}">
                                        <label for="add_l_4" class="col-sm-4 control-label">Address Line 4</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="add_l_4"
                                                value="{{ old('add_l_4') ? old('add_l_4') : get_option('add_l_4') }}"
                                                name="add_l_4" placeholder="Address Line 4">
                                            {!! $errors->has('add_l_4') ? '<p class="help-block">' . $errors->first('add_l_4') . '</p>' : '' !!}
                                        </div>
                                    </div>
                                    <div
                                        class="form-group row {{ $errors->has('working_hours_heading') ? 'has-error' : '' }}">
                                        <label for="working_hours_heading" class="col-sm-4 control-label">Working Hours
                                            Heading</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="working_hours_heading"
                                                value="{{ old('working_hours_heading') ? old('working_hours_heading') : get_option('working_hours_heading') }}"
                                                name="working_hours_heading" placeholder="Working Hours Heading">
                                            {!! $errors->has('working_hours_heading')
                                                ? '<p class="help-block">' . $errors->first('working_hours_heading') . '</p>'
                                                : '' !!}
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('working_hours') ? 'has-error' : '' }}">
                                        <label for="working_hours" class="col-sm-4 control-label">Working Hour's</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="working_hours"
                                                value="{{ old('working_hours') ? old('working_hours') : get_option('working_hours') }}"
                                                name="working_hours" placeholder="Working Hour's">
                                            {!! $errors->has('working_hours') ? '<p class="help-block">' . $errors->first('working_hours') . '</p>' : '' !!}
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="form-group row">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <button type="submit" id="settings_save_btn" class="btn btn-primary">Save
                                                Settings</button>
                                        </div>
                                    </div>

                                    {{ html()->form()->close() }}
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
    </div>
@endsection

@section('page-js')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
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
