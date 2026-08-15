@extends('layouts.backend')
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Trashed Treatment Plans</h5>
                            <div class="card-tools">
                                <a href="{{ route('treatment-plans.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
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
                                        <th>Status</th>
                                        <th>Deleted At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($plans as $plan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $plan->patient->name ?? 'N/A' }}</td>
                                            <td>{{ ucfirst($plan->status) }}</td>
                                            <td>{{ $plan->deleted_at ? $plan->deleted_at->format('d M y h:i A') : 'N/A' }}</td>
                                            <td>
                                                @can('restore-treatment-plan')
                                                {{ Html()->form('POST')->route('treatment-plans.restore', $plan->id)->open() }}
                                                <button type="submit" class="btn btn-success btn-xs" onclick='return confirm("Restore?")'>
                                                    <i class="fa fa-undo"></i> Restore
                                                </button>
                                                {{ Html()->form()->close() }}
                                                @endcan
                                                @can('force-delete-treatment-plan')
                                                {{ Html()->form('DELETE')->route('treatment-plans.forceDelete', $plan->id)->open() }}
                                                <button type="submit" class="btn btn-danger btn-xs" onclick='return confirm("Permanently delete?")'>
                                                    <i class="fa fa-times"></i> Force Delete
                                                </button>
                                                {{ Html()->form()->close() }}
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">Trash is empty</td></tr>
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
