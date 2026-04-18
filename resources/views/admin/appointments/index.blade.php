@extends('layouts.backend')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Appointments</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Branch</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Time Slot</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->patient_name }}</td>
                    <td>{{ $appointment->branch->branchName }}</td>
                    <td>{{ $appointment->appointmentType->name }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
</div>
@endsection
