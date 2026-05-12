@extends('layouts.backend')
@section('page-css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
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
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <?php
                                        $date = new DateTime();
                                        ?>
                                        <h5 class="m-0">Today's Patients Schedule ( {{ $date->format('d/m/y') }} )</h5>
                                    </div>
                                    <div class="col-md-8">
                                        <!-- Search and Branch Filter Form -->
                                        <form method="GET" action="{{ route('todayPatients') }}" class="row g-2 align-items-center justify-content-end">
                                            <!-- Search Input -->
                                            <div class="col-auto">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                                    </div>
                                                    <input type="text" name="search" class="form-control" 
                                                           placeholder="Search patient..." 
                                                           value="{{ $search ?? '' }}"
                                                           style="width: 180px;">
                                                </div>
                                            </div>
                                            <!-- Branch Filter -->
                                            <div class="col-auto">
                                                <select name="branch_id" id="branch_id" class="form-control form-control-sm">
                                                    <option value="">All Branches</option>
                                                    @forelse($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ $selectedBranchId == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->branchName }}
                                                        </option>
                                                    @empty
                                                        <option value="">No Branches Available</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            <!-- Submit Button -->
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-filter"></i> Filter
                                                </button>
                                            </div>
                                            <!-- Clear Button -->
                                            @if($selectedBranchId || $search)
                                                <div class="col-auto">
                                                    <a href="{{ route('todayPatients') }}" class="btn btn-secondary btn-sm">
                                                        <i class="fa fa-times"></i> Clear
                                                    </a>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="padding: .25rem; font-size:12px;">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Patient Name</th>
                                        <th>Mobile</th>
                                        <th>Diagnosis</th>
                                        <th>Branch</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @forelse($DailyPatients as $s)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                                <?php
                                                $source = $s->patient->created_at;
                                                $date = new DateTime($s->patient->created_at);
                                                ?>
                                            <a href="{{ route('patients.show',$s->patient->id ) }}" data-toggle="tooltip" data-placement="top" title="GPC-{{ $s->patient->patientId.'-'.$date->format('m/y') }}">{{ ucfirst($s->patient->name) }}
                                                @if($s->patient->gender == 1)
                                                    (M {{ $s->patient->age }})
                                                @else
                                                    (F {{ $s->patient->age }})
                                                @endif

                                            </a>
                                        </td>
                                        <td>{{ $s->patient->mobile }}</td>
                                        <td>{{ $s->patient->diagnosis }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $s->branch->branchName ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            @if($s->attendedAt)
                                                <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                                            @else
                                                <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($s->payment)
                                                @if($s->payment->collections->sum('amount')+$s->payment->collections->sum('discount') >= $s->payment->amount )
                                                    <span class="badge badge-success">Paid</span>
                                                @else
                                                    <span class="badge badge-warning">Pending</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $s->title }}</td>
                                        <td>
                                            @if($s->attendedAt)
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fab fa-paypal"></i>
                                                </button>

                                            @else
                                          		@if($s->status == 2)
                                                    <button type="submit" class="btn btn-default btn-sm">
                                                         AB
                                                    </button>

                                                 @else
                                                {{ Html()->form('PATCH')->route('schedules.update', $s)->style('display:inline')->open() }}
                                                <input type="text" class="form-control" name="attendedAt" value="<?php echo \Carbon\Carbon::now(); ?>" hidden>
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fab fa-paypal"></i>
                                                </button>
                                                {{ Html()->form()->close() }}
												 @if(!$s->attendedAt)
                                          			{{ Html()->form('PATCH')->route('makeAbsent', $s)->style('display:inline')->open() }}

                                                       <input type="text" class="form-control" name="status" value="2" hidden>
                                                          <button type="submit" class="btn btn-danger btn-sm">
                                                              AB
                                                           </button>
                                                      {{ Html()->form()->close() }}
                                                  @endif
                                          	@endif
                                            @endif
                                            <a href="{{ route('patients.show',$s->patient->id) }}" target="_blank" class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No patients found for today</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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
    <!-- DataTables  & Plugins -->
    <script src="{{ url('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backend/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
