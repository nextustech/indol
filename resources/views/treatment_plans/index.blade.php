@extends('layouts.backend')
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Treatment Plans</h5>
                            <div class="card-tools">
                                @can('view-trash-treatment-plan')
                                <a href="{{ route('treatment-plans.trash') }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Trash</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            @include('errors.list')
                            @if (Session::has('message'))
                                <div class="alert alert-success text-center m-2">{{ session('message') }}</div>
                            @endif
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient</th>
                                        <th>Assessment Date</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Exercises</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($plans as $plan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $plan->patient->name ?? 'N/A' }}</td>
                                            <td>{{ $plan->assessment->assessment_date ? $plan->assessment->assessment_date->format('d M y') : 'N/A' }}</td>
                                            <td>
                                                @if($plan->status == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @elseif($plan->status == 'completed')
                                                    <span class="badge badge-info">Completed</span>
                                                @else
                                                    <span class="badge badge-secondary">Discontinued</span>
                                                @endif
                                            </td>
                                            <td>{{ $plan->creator->name ?? 'N/A' }}</td>
                                            <td>{{ $plan->exercises->count() }}</td>
                                            <td>
                                                <a href="{{ route('assessments.show', $plan->assessment_id) }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center">No treatment plans found</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">{{ $plans->appends(request()->query())->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
