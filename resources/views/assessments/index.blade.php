@extends('layouts.backend')
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Physiotherapy Assessments</h5>
                            <div class="card-tools">
                                @can('create-Assessment')
                                <a href="{{ route('assessments.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> New Assessment
                                </a>
                                @endcan
                                @can('view-trash-assessment')
                                <a href="{{ route('assessments.trash') }}" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Trash
                                </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            @include('errors.list')
                            @if (Session::has('message'))
                                <div class="alert alert-success text-center">{{ session('message') }}</div>
                            @endif
                            <form action="" method="GET">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Branch:</label>
                                        <select class="form-control" name="branch_id">
                                            <option value="">All Branches</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->branchName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Search Patient:</label>
                                        <input type="text" class="form-control" name="search" placeholder="Name, ID, Mobile..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">All Assessments</h5>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Patient</th>
                                        <th>Patient ID</th>
                                        <th>Type</th>
                                        <th>Assessed By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($assessments as $assessment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $assessment->assessment_date->format('d M y') }}</td>
                                            <td>{{ $assessment->patient->name ?? 'N/A' }}</td>
                                            <td>{{ $assessment->patient->patientId ?? 'N/A' }}</td>
                                            <td>{{ ucfirst($assessment->type) }}</td>
                                            <td>{{ $assessment->assessedBy->name ?? 'N/A' }}</td>
                                            <td>
                                                @if($assessment->status == 'completed')
                                                    <span class="badge badge-success">Completed</span>
                                                @else
                                                    <span class="badge badge-warning">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @can('show-AssessmentProfile')
                                                    <a href="{{ route('assessments.show', $assessment->id) }}" class="btn btn-info btn-xs" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @endcan
                                                    @can('print-Assessment')
                                                    <a href="{{ route('assessmentPrint', $assessment->id) }}" class="btn btn-success btn-xs" title="Print" target="_blank">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                    @endcan
                                                    @can('edit-Assessment')
                                                    <a href="{{ route('assessments.edit', $assessment->id) }}" class="btn btn-warning btn-xs" title="Edit">
                                                        <i class="fa fa-pen"></i>
                                                    </a>
                                                    @endcan
                                                    @can('delete-Assessment')
                                                    {{ Html()->form('DELETE')->route('assessments.destroy', $assessment->id)->open() }}
                                                    <button type="submit" class="btn btn-danger btn-xs" onclick='return confirm("Are you sure?")' title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    {{ Html()->form()->close() }}
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8" class="text-center">No assessments found</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $assessments->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
