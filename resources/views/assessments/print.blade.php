<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Physiotherapy Assessment - {{ $assessment->patient->name ?? '' }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @page { margin: 15mm; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #333; }
        .header h2 { margin: 0; font-size: 20px; }
        .header h4 { margin: 5px 0; font-size: 14px; color: #555; }
        .patient-info { margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .patient-info table { width: 100%; }
        .patient-info td { padding: 2px 8px; }
        .section-title { font-size: 14px; font-weight: bold; background: #f0f0f0; padding: 6px 10px; margin: 15px 0 8px 0; border-left: 4px solid #333; }
        .field-label { font-weight: bold; font-size: 11px; color: #666; text-transform: uppercase; margin-top: 8px; }
        .field-value { white-space: pre-wrap; padding: 2px 0 6px 0; }
        .table-sm th { background: #f8f9fa; }
        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px solid #ddd; text-align: center; font-size: 10px; color: #888; }
        .badge-status { display: inline-block; padding: 2px 8px; font-size: 11px; border-radius: 3px; }
        .badge-success { background: #28a745; color: #fff; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-info { background: #17a2b8; color: #fff; }
        .row { display: flex; flex-wrap: wrap; margin: 0 -8px; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; padding: 0 8px; box-sizing: border-box; }
        hr { border: none; border-top: 1px solid #dee2e6; margin: 10px 0; }
        @media print {
            .no-print { display: none; }
            .section-title { break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="text-center no-print mb-3">
        <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
        <button class="btn btn-secondary" onclick="window.close()">Close</button>
    </div>

    <div class="header">
        <h2>Rx Physio Clinic</h2>
        <h4>Dr. Indolia Physiotherapy Clinic</h4>
        <h5>Physiotherapy Assessment Report</h5>
    </div>

    <div class="patient-info">
        <table>
            <tr>
                <td><strong>Patient Name:</strong> {{ $assessment->patient->name ?? 'N/A' }}</td>
                <td><strong>Patient ID:</strong> {{ $assessment->patient->patientId ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Age/Sex:</strong> {{ $assessment->patient->age ?? 'N/A' }} / {{ $assessment->patient->gender ?? 'N/A' }}</td>
                <td><strong>Mobile:</strong> {{ $assessment->patient->mobile ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Assessment Date:</strong> {{ $assessment->assessment_date->format('d M Y, h:i A') }}</td>
                <td>
                    <strong>Type:</strong> {{ ucfirst($assessment->type) }} &nbsp;
                    <strong>Status:</strong> {{ ucfirst($assessment->status) }}
                </td>
            </tr>
            <tr>
                <td><strong>Assessed By:</strong> {{ $assessment->assessedBy->name ?? 'N/A' }}</td>
                <td><strong>Branch:</strong> {{ $assessment->branch->branchName ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    @if($assessment->chief_complaints)
    <div class="section-title">Chief Complaints</div>
    <div class="field-value">{{ $assessment->chief_complaints }}</div>
    @endif

    @if($assessment->history_of_present_illness)
    <div class="section-title">History of Present Illness</div>
    <div class="field-value">{{ $assessment->history_of_present_illness }}</div>
    @endif

    @if($assessment->observation || $assessment->palpation || $assessment->range_of_motion || $assessment->muscle_strength || $assessment->special_tests || $assessment->neurological || $assessment->postural_assessment || $assessment->clinical_impression)
    <div class="section-title">Objective Examination</div>
    <div class="row">
        @if($assessment->observation)
        <div class="col-md-6">
            <div class="field-label">Observation</div>
            <div class="field-value">{{ $assessment->observation }}</div>
        </div>
        @endif
        @if($assessment->palpation)
        <div class="col-md-6">
            <div class="field-label">Palpation</div>
            <div class="field-value">{{ $assessment->palpation }}</div>
        </div>
        @endif
    </div>
    <div class="row">
        @if($assessment->range_of_motion)
        <div class="col-md-6">
            <div class="field-label">Range of Motion</div>
            <div class="field-value">{{ $assessment->range_of_motion }}</div>
        </div>
        @endif
        @if($assessment->muscle_strength)
        <div class="col-md-6">
            <div class="field-label">Muscle Strength</div>
            <div class="field-value">{{ $assessment->muscle_strength }}</div>
        </div>
        @endif
    </div>
    <div class="row">
        @if($assessment->special_tests)
        <div class="col-md-6">
            <div class="field-label">Special Tests</div>
            <div class="field-value">{{ $assessment->special_tests }}</div>
        </div>
        @endif
        @if($assessment->neurological)
        <div class="col-md-6">
            <div class="field-label">Neurological</div>
            <div class="field-value">{{ $assessment->neurological }}</div>
        </div>
        @endif
    </div>
    <div class="row">
        @if($assessment->postural_assessment)
        <div class="col-md-6">
            <div class="field-label">Postural Assessment</div>
            <div class="field-value">{{ $assessment->postural_assessment }}</div>
        </div>
        @endif
        @if($assessment->clinical_impression)
        <div class="col-md-6">
            <div class="field-label">Clinical Impression</div>
            <div class="field-value">{{ $assessment->clinical_impression }}</div>
        </div>
        @endif
    </div>
    @endif

    @if($assessment->investigations->count() > 0)
    <div class="section-title">Investigations</div>
    <table class="table table-bordered table-sm" width="100%" cellpadding="4">
        <thead>
            <tr>
                <th>Type</th>
                <th>Date</th>
                <th>Findings</th>
                <th>Facility</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assessment->investigations as $inv)
            <tr>
                <td>{{ $inv->type }}</td>
                <td>{{ $inv->investigation_date ? $inv->investigation_date->format('d M Y') : 'N/A' }}</td>
                <td>{{ $inv->findings ?? 'N/A' }}</td>
                <td>{{ $inv->facility ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($assessment->treatmentPlan)
    @php $plan = $assessment->treatmentPlan; @endphp
    <div class="section-title" style="border-left-color: #28a745;">Treatment Plan</div>
    <div class="row">
        @if($plan->short_term_goals)
        <div class="col-md-6">
            <div class="field-label">Short-term Goals</div>
            <div class="field-value">{{ $plan->short_term_goals }}</div>
        </div>
        @endif
        @if($plan->long_term_goals)
        <div class="col-md-6">
            <div class="field-label">Long-term Goals</div>
            <div class="field-value">{{ $plan->long_term_goals }}</div>
        </div>
        @endif
    </div>
    <div class="row">
        @if($plan->precautions)
        <div class="col-md-6">
            <div class="field-label" style="color: #dc3545;">Precautions / Avoid</div>
            <div class="field-value">{{ $plan->precautions }}</div>
        </div>
        @endif
        @if($plan->advice)
        <div class="col-md-6">
            <div class="field-label" style="color: #28a745;">Advice</div>
            <div class="field-value">{{ $plan->advice }}</div>
        </div>
        @endif
    </div>
    @if($plan->follow_up_instructions)
    <div class="field-label">Follow-up Instructions</div>
    <div class="field-value">{{ $plan->follow_up_instructions }}</div>
    @endif

    @if($plan->exercises->count() > 0)
    <hr>
    <h6>Exercise Prescription</h6>
    <table class="table table-bordered table-sm" width="100%" cellpadding="4">
        <thead>
            <tr>
                <th>Exercise</th>
                <th>Category</th>
                <th>Sets</th>
                <th>Reps</th>
                <th>Frequency</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plan->exercises as $ex)
            <tr>
                <td><strong>{{ $ex->exercise_name }}</strong></td>
                <td>{{ ucfirst($ex->category) }}</td>
                <td>{{ $ex->sets ?? '-' }}</td>
                <td>{{ $ex->repetitions ?? '-' }}</td>
                <td>{{ $ex->frequency ?? '-' }}</td>
                <td>{{ $ex->duration ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @endif

    <div class="footer">
        <p>Rx Physio Clinic — Dr. Indolia Physiotherapy Clinic | Generated on {{ now()->format('d M Y, h:i A') }}</p>
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
