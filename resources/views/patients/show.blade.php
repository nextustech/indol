@extends('layouts.backend')
@section('page-css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/basic.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ url('backend/plugins/ekko-lightbox/ekko-lightbox.css') }}">
    <style>
        .ui-datepicker{ z-index:9999!important; }
    </style>
    <style type="text/css">
        .old{display: none;
            width: 500px;
        }
        .bx{
            display: none;
            margin-top: 20px;
        }
    </style>
    <style type="text/css">
        .dropzone {
            border: 2px dashed #999999;
            border-radius: 10px;
        }

        .dropzone .dz-default.dz-message {
            height: 171px;
            background-size: 132px 132px;
            margin-top: -101.5px;
            background-position-x: center;

        }

        .dropzone .dz-default.dz-message span {
            display: block;
            margin-top: 145px;
            font-size: 20px;
            text-align: center;
        }
    </style>



@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{ url('backend/img/user4-128x128.jpg') }}"
                                         alt="User profile picture">
                                </div>
                                <li class="btn-group mb-2 mt-2">
                                    <button class="btn btn-outline-danger btn-sm">
                                        Reg. :
                                        <?php
                                        $source = $patient->date;
                                        $date = new DateTime($source);
                                        ?>
                                        {{ $date->format(" j M, y") }}

                                    </button>
                                    <a href="{{ route('patients.edit',$patient) }}" class="btn btn-outline-danger btn-sm">
                                        <i class="fa fa-pen"></i>
                                    </a>&nbsp;
                                        {{ Html()->form('DELETE')->route('patients.destroy',$patient->id)->open() }}
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick='
                                                        if(confirm("Are you sure?") == false) {
                                                            return false;
                                                        } else {
                                                            //
                                                        }'>
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    {{ html()->form()->close() }}

                                </li>

                                <h3 class="profile-username text-center">{{ $patient->name }}</h3>

                                <p class="text-muted text-center">
                                    @if($patient->gender == 1)
                                        M
                                    @elseif($patient->gender == 2)
                                        F
                                    @else
                                        N.A
                                    @endif
                                    &nbsp; {{ $patient->age  }} Yrs
                                </p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Mobile : </b> <a class="float-right">{{ $patient->mobile }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Patient ID :</b> <a class="float-right">GPC - {{ $patient->id }}</a>
                                    </li>
                                    <li class="list-group-item">
                                      <a class="float-right">
                                            @foreach( $patient->branches as $branch)
                                                {{ $branch->branchName }}
                                            @endforeach

                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('getChangeBranch',$patient->id) }}" class="btn btn-block btn-outline-info">
                                            Change Branch
                                        </a>
                                    </li>
                                </ul>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fas fa-book mr-1"></i> Diagnosis</strong>

                                <p class="text-muted">
                                    {{ $patient->diagnosis }}
                                </p>

                                <hr>

                                <strong><i class="fas fa-pencil-alt mr-1"></i> Reffered By</strong>

                                <p class="text-muted">{{ $patient->ref_by }}</p>

                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                                <p class="text-muted">
                                    {{ $patient->address }}
                                </p>

                                <hr>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card card-primary card-outline">
                            <div class="card-header p-2">
                                <div class="card-title">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Reports</a></li>

                                    </ul>
                                </div>
                                <div class="card-tool float-right">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a href="{{ route('invoices.cr',['id' => $patient->id]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-inr"></i> Create Bill
                                            </a>

                                        </li>
                                    </ul>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body" style="padding: .25rem; font-size:12px;">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <table class="table table-bordered table-hover" >
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Pakage</th>
                                                <th>Days</th>
                                                <th>Amount</th>
                                                <th>Paid(Dis.)</th>
                                                <th>Balance</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($patient->status == NULL)
                                                @foreach($patient->payments->sortByDesc('date') as $pay)

                                                    <tr>
                                                        <td style="padding: .5rem;">
                                                                <?php
                                                                $source = $pay->date;
                                                                $date = new DateTime($source);
                                                                ?>
                                                            {{ $date->format(" j M, y") }}

                                                        </td>
                                                        <td style="padding: .5rem;">
                                                            {{ $pay->title }}
                                                            @if($pay->active == 1)
                                                                <span ><i class="fa fa-circle" style="color:green" aria-hidden="true"></i></span>
                                                            @endif
                                                        </td>
                                                        <td style="padding: .5rem;"> {{ $pay->duration }}</td>
                                                        <td style="padding: .5rem;">@can('PatientCollectionView') Rs.{{ $pay->amount }} @endcan</td>
                                                        <td style="padding: .5rem;"> @can('PatientCollectionView') Rs.{{ $pay->collections->sum('amount') }} @if($pay->collections->sum('discount'))({{ $pay->collections->sum('discount') }})@endif @endcan</td>
                                                        <td style="padding: .5rem;"> @can('PatientCollectionView') Rs.{{ $pay->amount-($pay->collections->sum('amount')+$pay->collections->sum('discount')) }} @endcan</td>
                                                        {{--                <td>--}}

                                                        {{--                    @if($pay->collections->sum('refund'))--}}
                                                        {{--                        RF : <a href="{{ route('getRefundDetail',[ 'pid'=>$patient->id, 'payId' => $pay->id]) }}">{{ $pay->collections->sum('refund')}} </a>--}}
                                                        {{--                    @else--}}
                                                        {{--                        <div class="btn-group mt-2 mb-2">--}}
                                                        {{--                            @if($pay->collections->sum('amount')+$pay->collections->sum('discount') >= $pay->amount )--}}
                                                        {{--                                <button class="btn btn-outline-success btn-sm">--}}
                                                        {{--                                    Paid--}}
                                                        {{--                                </button>--}}
                                                        {{--                            @else--}}
                                                        {{--                                <a href="{{ route('collection.cr',['id' => $pay->id]) }}" class="btn btn-outline-danger btn-sm">--}}
                                                        {{--                                    <i class="fa fa-inr"></i> Pay--}}
                                                        {{--                                </a>--}}


                                                        {{--                            @endif--}}
                                                        {{--                            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown"  style="overflow-x: unset">--}}
                                                        {{--                                <span class="caret"></span>--}}
                                                        {{--                                <span class="sr-only">Toggle Dropdown</span>--}}
                                                        {{--                            </button>--}}
                                                        {{--                            <ul class="dropdown-menu text-center" role="menu">--}}
                                                        {{--                                <li>--}}
                                                        {{--                                    <div class="btn-group text-center">--}}
                                                        {{--                                        <a href="{{ route('payIndex',$pay->id) }}" class="btn btn-danger btn-sm">--}}
                                                        {{--                                            <i class="fa fa-search"></i>--}}
                                                        {{--                                        </a>--}}
                                                        {{--                                        <a href="{{ route('editDate',$pay->id) }}" class="btn btn-danger btn-sm">--}}
                                                        {{--                                            <i class="fa fa-pencil"></i>--}}
                                                        {{--                                        </a>--}}

                                                        {{--                                        {{ Html()->form('DELETE')->route('payment.destroy', $pay->id)->open() }}--}}

                                                        {{--                                        <button type="submit" class="btn btn-danger btn-sm" onclick='--}}
                                                        {{--                                                                                    if(confirm("Are you sure?") == false) {--}}
                                                        {{--                                                                                        return false;--}}
                                                        {{--                                                                                    } else {--}}
                                                        {{--                                                                                        //--}}
                                                        {{--                                                                                    }'>--}}
                                                        {{--                                                <i class="fa fa-trash-o"></i>--}}
                                                        {{--                                            </button>--}}

                                                        {{--                                        {{ Html()->form()->close() }}--}}

                                                        {{--                                        @if($pay->active != 1)--}}
                                                        {{--                                            {{ Form::model($pay, array('route' => array('makeActive', $pay->id), 'method' => 'PATCH','style'=>'display:inline')) }}--}}
                                                        {{--                                            --}}
                                                        {{--                                            <input type="text" class="form-control" name="active" value="1" hidden>--}}
                                                        {{--                                            <button type="submit" class="btn btn-danger btn-sm">--}}
                                                        {{--                                                Activate--}}
                                                        {{--                                            </button>--}}
                                                        {{--                                            --}}
                                                        {{--                                        @endif--}}
                                                        {{--                                        <a href="{{ route('getRefund',['id' => $pay->id]) }}" class="btn btn-danger btn-sm">--}}
                                                        {{--                                            R--}}
                                                        {{--                                        </a>--}}



                                                        {{--                                    </div>--}}
                                                        {{--                                </li>--}}
                                                        {{--                            </ul>--}}
                                                        {{--                        </div>--}}

                                                        {{--                    @endif--}}

                                                        {{--                </td>--}}
                                                        <td style="padding: .5rem;">
                                                            <div class="btn-group">
                                                                @if($pay->collections->sum('refund'))
                                                                    RF : <a href="{{ route('getRefundDetail',[ 'pid'=>$patient->id, 'payId' => $pay->id]) }}">{{ $pay->collections->sum('refund')}} </a>
                                                                @else
                                                                    @if($pay->collections->sum('amount')+$pay->collections->sum('discount') >= $pay->amount )
                                                                        <button type="button" class="btn btn-success btn-xs"> Paid</button>
                                                                    @else
                                                              			@can('PatientCollectionView') 
                                                                        <a href="{{ route('collection.cr',['id' => $pay->id]) }}" class="btn btn-outline-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Make Payment">&#8377; Pay</a>
                                                                    	@endcan
                                                              		@endif
                                                                    @if($pay->active != 1)
                                                                        {{ Html()->form('PATCH')->route('makeActive', $pay)->open() }}
                                                                        <input type="text" class="form-control" name="active" value="1" hidden>
                                                                        <button type="submit" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Make Active"><i class="fa fa-bolt"></i></button>
                                                                        {{ Html()->form()->close() }}
                                                                    @endif
                                                              @can('PatientCollectionView') 
                                                                    <a href="{{ route('payIndex',$pay->id) }}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="View Collection!"><i class="fa fa-search-dollar"></i></a>
                                                                    <a href="{{ route('editDate',$pay->id) }}" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Date!"><i class="fa fa-pen-alt"></i></a>
                                                                    <a href="{{ route('getRefund',['id' => $pay->id]) }}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Make Refund!"><i class="fa fa-reply"></i></a>
																@can('deleteCollection')
                                                                    {{ Html()->form('DELETE')->route('payment.destroy', $pay->id)->open() }}
                                                                    <button type="submit" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Delete!" onclick='
                                                                                    if(confirm("Are you sure?") == false) {
                                                                                        return false;
                                                                                    } else {
                                                                                        //
                                                                                    }'>
                                                                        <i class="fa fa-trash" ></i>
                                                                    </button>
                                                                    {{ Html()->form()->close() }}
                                                              	@endcan
                                                                @endif
                                                              @endcan
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="timeline">
                                         <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#modal-sm">
                                            Upload Reports
                                        </button>

                                <div class="col-12 col-lg-6">
                                       <div class="row mb-3 row-cols-auto g-2 mt-3">
                                               <?php if(count($productImages)>0) {
                                           foreach($productImages as $images) { ?>
                                          {{-- <div class="col"><img src="{{ url($images->filePath)}}" width="70" class="border rounded cursor-pointer" alt="">
                                               <a href="{{url('upload/file/delete', $images->id)}}" title="delete"><i class="lni lni-trash "></i></a>
                                           </div> --}}
                                          <div class="col-sm-2">
                                            <a href="{{ url($images->filePath)}}" target="_blank" data-title="sample 1 - white" ">
                                              <img src="{{ url($images->filePath)}}" class="img-fluid mb-2" alt="white sample"/>
                                            </a>
                                          </div>
                                           <?php }} ?>
                                       </div>
                                </div> 
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="settings">
                                        settings
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        @include('patients.schedule')
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
                      <div class="modal fade" id="modal-sm">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Upload Reports </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12 col-lg-12">
                                    <label for="Position1" class="form-label">Upload Reports</label>


                                    {{ Html()->form('POST')->route('storeImages', $patient->id)->acceptsFiles('ture')->class('dropzone')->id('fileupload-a')->open() }}
                                    <div class="card-body row">
                                        <input type="hidden" name="id" value="{{ $patient->id }}">
                                        <div class="fallback">
                                            <input name="file" type="files" multiple
                                                   accept="image/jpeg, image/png, image/jpg , .pdf, .doc, .docx" />
                                        </div>
                                    </div>
                                    {{ html()->form()->close() }}
                                </div>



                                <div id="response" class="col-md-12"></div>


                            </div>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('page-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ url('backend/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#schedule').click(function(){
                var inputValue = $(this).attr("value");
                $("." + inputValue).toggle(this.checked);
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Activate the tab from the URL hash
            let hash = window.location.hash;
            if (hash) {
                $('.nav-pills a[href="' + hash + '"]').tab('show');
            }

            // Change the hash when a tab is clicked
            $('.nav-pills a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            });
        });
    </script>
    <script type="text/javascript">
        Dropzone.options.fileupload = {
            accept: function(file, done) {
                if (file.type != "application/vnd.ms-excel" && file.type !=
                    "image/jpeg, image/png, image/jpg, .pdf, .doc, .docx") {
                    done("Error! Files of this type are not accepted");
                } else {
                    done();
                }
            }
        }

        Dropzone.options.fileupload = {
            acceptedFiles: "image/jpeg, image/png, image/jpg, .pdf, .doc, .docx"
        }

        if (typeof Dropzone != 'undefined') {
            Dropzone.autoDiscover = false;
        };
        (function($, window, undefined) {
            "use strict";

            $(document).ready(function() {
                // Dropzone Example
                if (typeof Dropzone != 'undefined') {
                    if ($("#fileupload").length) {
                        var dz = new Dropzone("#fileupload"),
                            dze_info = $("#dze_info"),
                            status = {
                                uploaded: 0,
                                errors: 0
                            };
                        var $f = $(
                            '<tr><td class="name"></td><td class="size"></td><td class="type"></td><td class="status"></td></tr>'
                        );
                        dz.on("success", function(file, responseText) {

                            var _$f = $f.clone();

                            _$f.addClass('success');

                            _$f.find('.name').html(file.name);
                            if (file.size < 1024) {
                                _$f.find('.size').html(parseInt(file.size) + ' KB');
                            } else {
                                _$f.find('.size').html(parseInt(file.size / 1024, 10) + ' KB');
                            }
                            _$f.find('.type').html(file.type);
                            _$f.find('.status').html('Uploaded <i class="entypo-check"></i>');

                            dze_info.find('tbody').append(_$f);

                            status.uploaded++;

                            dze_info.find('tfoot td').html('<span class="label label-success">' + status
                                    .uploaded + ' uploaded</span> <span class="label label-danger">' +
                                status.errors + ' not uploaded</span>');

                            toastr.success('Your File Uploaded Successfully!!', 'Success Alert', {
                                timeOut: 50000000
                            });

                        })
                            .on('error', function(file) {
                                var _$f = $f.clone();

                                dze_info.removeClass('hidden');

                                _$f.addClass('danger');

                                _$f.find('.name').html(file.name);
                                _$f.find('.size').html(parseInt(file.size / 1024, 10) + ' KB');
                                _$f.find('.type').html(file.type);
                                _$f.find('.status').html('Uploaded <i class="entypo-cancel"></i>');

                                dze_info.find('tbody').append(_$f);

                                status.errors++;

                                dze_info.find('tfoot td').html('<span class="label label-success">' + status
                                        .uploaded + ' uploaded</span> <span class="label label-danger">' +
                                    status.errors + ' not uploaded</span>');

                                toastr.error('Your File Uploaded Not Successfully!!', 'Error Alert', {
                                    timeOut: 5000
                                });
                            });
                    }
                    if ($("#fileupload-a").length) {
                        var dz = new Dropzone("#fileupload-a"),
                            dze_info = $("#dze_info"),
                            status = {
                                uploaded: 0,
                                errors: 0
                            };
                        var $f = $(
                            '<tr><td class="name"></td><td class="size"></td><td class="type"></td><td class="status"></td></tr>'
                        );
                        dz.on("success", function(file, responseText) {

                            var _$f = $f.clone();

                            _$f.addClass('success');

                            _$f.find('.name').html(file.name);
                            if (file.size < 1024) {
                                _$f.find('.size').html(parseInt(file.size) + ' KB');
                            } else {
                                _$f.find('.size').html(parseInt(file.size / 1024, 10) + ' KB');
                            }
                            _$f.find('.type').html(file.type);
                            _$f.find('.status').html('Uploaded <i class="entypo-check"></i>');

                            dze_info.find('tbody').append(_$f);

                            status.uploaded++;

                            dze_info.find('tfoot td').html('<span class="label label-success">' + status
                                    .uploaded + ' uploaded</span> <span class="label label-danger">' +
                                status.errors + ' not uploaded</span>');

                            toastr.success('Your File Uploaded Successfully!!', 'Success Alert', {
                                timeOut: 50000000
                            });

                        })
                            .on('error', function(file) {
                                var _$f = $f.clone();

                                dze_info.removeClass('hidden');

                                _$f.addClass('danger');

                                _$f.find('.name').html(file.name);
                                _$f.find('.size').html(parseInt(file.size / 1024, 10) + ' KB');
                                _$f.find('.type').html(file.type);
                                _$f.find('.status').html('Uploaded <i class="entypo-cancel"></i>');

                                dze_info.find('tbody').append(_$f);

                                status.errors++;

                                dze_info.find('tfoot td').html('<span class="label label-success">' + status
                                        .uploaded + ' uploaded</span> <span class="label label-danger">' +
                                    status.errors + ' not uploaded</span>');

                                toastr.error('Your File Uploaded Not Successfully!!', 'Error Alert', {
                                    timeOut: 5000
                                });
                            });
                    }
                }
            });
        })(jQuery, window);
    </script>
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>

@endsection
