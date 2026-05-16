@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-warning card-outline">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="m-0">Trash - Collections</h5>
                                <a href="{{ route('collection.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back to Collections
                                </a>
                            </div>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                @if($collections->count() > 0)
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($collections as $key => $collection)
                                        <tr>
                                            <td>{{ $collections->firstItem() + $key }}</td>
                                            <td>{{ $collection->amount }}</td>
                                            <td>{{ $collection->collectionDate }}</td>
                                            <td>{{ $collection->deleted_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                @can('restore-collection')
                                                <form action="{{ route('collections.restore', $collection->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Restore this collection?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                                @can('force-delete-collection')
                                                <form action="{{ route('collections.forceDelete', $collection->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Permanently delete this collection? This cannot be undone.')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $collections->links() }}
                                @else
                                <p class="text-center text-muted">No deleted collections found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
