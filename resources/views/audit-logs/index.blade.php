@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Audit Log</h5>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('audit-logs.index') }}" class="mb-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select name="action" class="form-control form-control-sm">
                                                <option value="">All Actions</option>
                                                @foreach($actions as $action)
                                                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('_', ' ', $action)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="model_type" class="form-control form-control-sm">
                                                <option value="">All Models</option>
                                                @foreach($models as $model)
                                                    <option value="{{ $model }}" {{ request('model_type') == $model ? 'selected' : '' }}>
                                                        {{ $model }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="user_id" class="form-control form-control-sm">
                                                <option value="">All Users</option>
                                                @foreach($users as $id => $name)
                                                    <option value="{{ $id }}" {{ request('user_id') == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                            <a href="{{ route('audit-logs.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </form>

                                @if($logs->count() > 0)
                                <table class="table table-sm table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Action</th>
                                        <th>Model</th>
                                        <th>User</th>
                                        <th>IP Address</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $logs->firstItem() + $loop->index }}</td>
                                            <td>
                                                @if($log->action == 'soft_delete')
                                                    <span class="badge badge-danger">Soft Deleted</span>
                                                @elseif($log->action == 'restore')
                                                    <span class="badge badge-success">Restored</span>
                                                @elseif($log->action == 'force_delete')
                                                    <span class="badge badge-dark">Force Deleted</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $log->action }}</span>
                                                @endif
                                            </td>
                                            <td>{{ class_basename($log->model_type) }} #{{ $log->model_id }}</td>
                                            <td>{{ $log->user->name ?? 'System' }}</td>
                                            <td>{{ $log->ip_address ?? '-' }}</td>
                                            <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $logs->links() }}
                                @else
                                <p class="text-center text-muted">No audit logs found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
