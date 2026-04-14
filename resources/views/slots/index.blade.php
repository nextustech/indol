@extends('layouts.backend')

@section('content')

<div class="content-wrapper">
<div class="content mt-3">
<div class="container-fluid">

<div class="card">
<div class="card-header d-flex justify-content-between">
<h5>Slots</h5>
<a href="{{ route('slots.create') }}" class="btn btn-primary">Add Slot</a>
</div>

<div class="card-body">

<table class="table table-bordered">
<tr>
<th>Time</th>
<th>Branch</th>
<th>Doctor</th>
<th>Max</th>
<th>Days</th>
</tr>

@foreach($slots as $slot)
<tr>
<td>{{ $slot->start_time }} - {{ $slot->end_time }}</td>
<td>{{ $slot->branch->branchName }}</td>
<td>{{ $slot->doctor->name ?? 'All' }}</td>
<td>{{ $slot->max_booking }}</td>
<td>
@foreach($slot->days as $d)
<span class="badge badge-info">
{{ ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][$d->day] }}
</span>
@endforeach
</td>
</tr>
@endforeach

</table>

</div>
</div>

</div>
</div>
</div>

@endsection
