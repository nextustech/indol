@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-warning card-outline">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="m-0">Trash - Calls</h5>
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                @if(count($calls) > 0)
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Patient</th>
                                        <th>Mobile</th>
                                        <th>Call At</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($calls as $call)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $call->patient->name ?? 'N/A' }}</td>
                                            <td>{{ $call->mobile }}</td>
                                            <td>{{ $call->call_at }}</td>
                                            <td>{{ $call->deleted_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                @can('restore-call')
                                                <form action="{{ route('calls.restore', $call->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Restore this call?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                                @can('force-delete-call')
                                                <form action="{{ route('calls.forceDelete', $call->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Permanently delete this call?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p class="text-center text-muted">No deleted calls found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
