@if($newPatientsList->count() > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h5 class="card-title">Today's New Patients ({{ $newPatients }})</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Mobile</th>
                                <th>Diagnosis</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newPatientsList as $patient)
                                <tr>
                                    <td>{{ $patient->created_at->format('d M y') }}</td>
                                    <td>GPC-{{ $patient->patientId }}{{ $patient->created_at->format('m/y') }}</td>
                                    <td>{{ ucfirst($patient->name) }}</td>
                                    <td>{{ $patient->age }}</td>
                                    <td>{{ ucfirst($patient->gender) }}</td>
                                    <td>{{ $patient->mobile }}</td>
                                    <td>{{ $patient->diagnosis ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-success" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-body text-center">
                    <p class="text-muted">No new patients registered today</p>
                </div>
            </div>
        </div>
    </div>
@endif