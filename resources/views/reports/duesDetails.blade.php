@extends('layouts.backend')

@section('content')
<div class="content-wrapper">

    <div class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Due's Details</h5>
                        </div>

                        <div class="card-body">
                            @include('errors.list')

                            @if(Session::has('message'))
                                <div class="alert alert-success text-center">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Reg Date</th>
                                        <th>Branch</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Payable</th>
                                        <th>Collection</th>
                                        <th>Discount</th>
                                        <th>Total Due</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @forelse($patients as $patient)

                                    @php
                                        $payable = $patient->total_payable ?? 0;
                                        $collection = $patient->total_collection ?? 0;
                                        $discount = $patient->total_discount ?? 0;
                                        $due = $payable - ($collection + $discount);
                                    @endphp
								@if($due >= 1)
                                    <tr>
                                        <td>
                                            {{ $patient->date ? \Carbon\Carbon::parse($patient->date)->format('j M, y') : '-' }}
                                        </td>

                                        <td>
                                            @if($patient->branches && count($patient->branches))
                                                @foreach($patient->branches as $branch)
                                                    {{ $branch->branchName }}
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('patients.show', $patient) }}">
                                                {{ ucfirst($patient->name) }}
                                            </a>
                                        </td>

                                        <td>{{ $patient->mobile ?? '-' }}</td>

                                        <td>{{ $payable }}</td>
                                        <td>{{ $collection }}</td>
                                        <td>{{ $discount }}</td>

                                        <td>
                                            <strong @if($due > 0) style="color:red" @endif>
                                                {{ $due }}
                                            </strong>
                                        </td>
                                    </tr>
								@endif
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            No records found
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $patients->links() }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection