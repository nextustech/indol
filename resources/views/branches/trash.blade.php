@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-warning card-outline">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="m-0">Trash - Branches</h5>
                                <a href="{{ route('branches.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back to Branches
                                </a>
                            </div>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif

                                @include('partials.bulk-actions')

                                @if(count($branches) > 0)
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all" onclick="toggleSelectAll(this)"></th>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Branch Phone</th>
                                        <th>Branch Email</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($branches as $branch)
                                        <tr>
                                            <td><input type="checkbox" class="bulk-checkbox" value="{{ $branch->id }}" onchange="updateBulkBar()"></td>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $branch->branchName }}</td>
                                            <td>{{ $branch->address }}</td>
                                            <td>{{ $branch->branchPhone }}</td>
                                            <td>{{ $branch->branchEmail }}</td>
                                            <td>{{ $branch->deleted_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <form action="{{ route('branches.restore', $branch->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Restore this branch?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('branches.forceDelete', $branch->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Permanently delete this branch? This cannot be undone.')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p class="text-center text-muted">No deleted branches found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
