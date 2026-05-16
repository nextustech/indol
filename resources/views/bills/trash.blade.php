@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-warning card-outline">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="m-0">Trash - Bills</h5>
                                <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back to Invoices
                                </a>
                            </div>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                @if(count($bills) > 0)
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Package</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($bills as $bill)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $bill->packageName }}</td>
                                            <td>{{ $bill->amount }}</td>
                                            <td>{{ $bill->date }}</td>
                                            <td>{{ $bill->deleted_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <form action="{{ route('bills.restore', $bill->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Restore this bill?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('bills.forceDelete', $bill->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Permanently delete this bill?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p class="text-center text-muted">No deleted bills found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
