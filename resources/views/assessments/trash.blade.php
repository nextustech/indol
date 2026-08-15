@extends('layouts.backend')
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Trashed Assessments</h5>
                            <div class="card-tools">
                                <a href="{{ route('assessments.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            @if (Session::has('message'))
                                <div class="alert alert-success text-center m-2">{{ session('message') }}</div>
                            @endif
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Deleted At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($assessments as $assessment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $assessment->patient->name ?? 'N/A' }}</td>
                                            <td>{{ ucfirst($assessment->type) }}</td>
                                            <td>{{ $assessment->assessment_date ? $assessment->assessment_date->format('d M y') : 'N/A' }}</td>
                                            <td>{{ $assessment->deleted_at ? $assessment->deleted_at->format('d M y h:i A') : 'N/A' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    @can('restore-assessment')
                                                    {{ Html()->form('POST')->route('assessments.restore', $assessment->id)->open() }}
                                                    <button type="submit" class="btn btn-success btn-xs" onclick='return confirm("Restore this assessment?")'>
                                                        <i class="fa fa-undo"></i> Restore
                                                    </button>
                                                    {{ Html()->form()->close() }}
                                                    @endcan
                                                    @can('force-delete-assessment')
                                                    {{ Html()->form('DELETE')->route('assessments.forceDelete', $assessment->id)->open() }}
                                                    <button type="submit" class="btn btn-danger btn-xs" onclick='return confirm("Permanently delete? This cannot be undone.")'>
                                                        <i class="fa fa-times"></i> Force Delete
                                                    </button>
                                                    {{ Html()->form()->close() }}
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center">Trash is empty</td></tr>
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
