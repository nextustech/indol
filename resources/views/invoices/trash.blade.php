@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-warning card-outline">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="m-0">Trash - Invoices</h5>
                                <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back to Invoices
                                </a>
                            </div>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                @if(count($invoices) > 0)
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Invoice No</th>
                                        <th>Patient</th>
                                        <th>Date</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($invoices as $invoice)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $invoice->invoiceNo }}</td>
                                            <td>{{ $invoice->patient->name ?? 'N/A' }}</td>
                                            <td>{{ $invoice->date }}</td>
                                            <td>{{ $invoice->deleted_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <form action="{{ route('invoices.restore', $invoice->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Restore this invoice?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('invoices.forceDelete', $invoice->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Permanently delete this invoice? This cannot be undone.')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p class="text-center text-muted">No deleted invoices found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
