@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-warning card-outline">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="m-0">Trash - Patients</h5>
                                <a href="{{ route('patients.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back to Patients
                                </a>
                            </div>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                @include('partials.bulk-actions')

                                @if($patients->count() > 0)
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all" onclick="toggleSelectAll(this)"></th>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Mobile</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($patients as $key => $patient)
                                        <tr>
                                            <td><input type="checkbox" class="bulk-checkbox" value="{{ $patient->id }}" onchange="updateBulkBar()"></td>
                                            <td>{{ $patients->firstItem() + $key }}</td>
                                            <td>{{ $patient->name }}</td>
                                            <td>{{ $patient->phone }}</td>
                                            <td>{{ $patient->mobile }}</td>
                                            <td>{{ $patient->deleted_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <form action="{{ route('patients.restore', $patient->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Restore this patient?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('patients.forceDelete', $patient->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Permanently delete this patient? This cannot be undone.')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $patients->links() }}
                                @else
                                <p class="text-center text-muted">No deleted patients found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
