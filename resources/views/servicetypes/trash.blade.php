@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-warning card-outline">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="m-0">Trash - Service Types</h5>
                                <a href="{{ route('servicetypes.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back to Service Types
                                </a>
                            </div>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                @if(count($serviceTypes) > 0)
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Days</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($serviceTypes as $serviceType)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $serviceType->name }}</td>
                                            <td>{{ $serviceType->amount }}</td>
                                            <td>{{ $serviceType->days }}</td>
                                            <td>{{ $serviceType->deleted_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <form action="{{ route('servicetypes.restore', $serviceType->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Restore this service type?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('servicetypes.forceDelete', $serviceType->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Permanently delete this service type?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p class="text-center text-muted">No deleted service types found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
