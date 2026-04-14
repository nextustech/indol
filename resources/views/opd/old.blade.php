<div class="row">
    <div class="col-md-6">

        <div class="form-group">
            <select class="form-control select2 select2-show-search" name="patient_id" style="width: 100%" data-placeholder="Choose one (with searchbox)">
                <option value="">Search Patient</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name. ' ' .$patient->mobile }} @if($patient->branch) ( {{ 'B:' .$patient->branch->branchName }} ) @endif</option>
                @endforeach
            </select>
        </div>
      @can('BackDateEntry')
        <div class="form-group">
            <input type="date" class="form-control fc-datepicker" name="date" value="{{ old('from') }}" placeholder="MM/DD/YYYY" autocomplete="off">
        </div>
              @else
        <div class="form-group">
            <input type="text" class="form-control fc-datepicker" id="datepicker1" name="date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" readonly placeholder="Registration Date ( DD/MM/YYYY )" autocomplete="off">
        </div>
        @endcan
        <div class="form-group">
            <input type="text" class="form-control" name="amount" value="{{ old('amount') }}" id="amount" placeholder="Enter amount Here">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="days" value="{{ old('days') }}" id="days" placeholder="Enter days Here">
        </div>
        <div class="form-group">
            <input type="text" class="form-control"  id="serviceTitle" name="title" value="{{ old('title') }}" placeholder="Enter Package Title">
        </div>
        <div class="custom-controls-stacked">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="ptype"  value="1">
                <span class="custom-control-label">Post Paid</span>
            </label>
        </div>

        <div class="custom-controls-stacked">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="schedule" id="schedule2" value="dt" >
                <span class="custom-control-label">Create Schedule</span>
            </label>
        </div>

        <div class="row bx dt">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="from">From Date</label>
                    <input type="date" class="form-control fc-datepicker" name="from" value="{{ old('from') }}" placeholder="MM/DD/YYYY" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dailyVisits">Sessions Per Day</label>
                    <input type="number" class="form-control" name="dailyVisits" value="{{ old('dailyVisits', 1) }}" min="1" required>
                </div>
            </div>
        </div>
        <div class="row bx dt">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total Sessions</label>
                    <input type="number" class="form-control" name="total_sessions" value="{{ old('total_sessions') }}" min="1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Saturday Sessions</label>
                    <input type="number" class="form-control" name="saturday_sittings" value="{{ old('saturday_sittings') }}" placeholder="Optional override" min="0">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Sunday Sessions</label>
                    <input type="number" class="form-control" name="sunday_sittings" value="{{ old('sunday_sittings', 0) }}" min="0">
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6">

            <?php
            use App\Models\ServiceType;
            $user = Auth::user();
            $services = ServiceType::all();
            ?>
        <div class="form-group">
                    <select class="form-control select2" style="width: 100%"  id="serviceType" name="service_type_id" data-placeholder="Choose Service">
                <option value="" selected> Select service </option>
                @foreach( $services as $service)
                    <option value="{{ $service->id }}" {{ old('service_type_id') == $service->id  ? 'selected':'' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <?php
        $modes = \App\Models\Mode::all();
        ?>

            <div class="form-group">
            <select class="form-control select2" name="cash" data-placeholder="Choose Payment Method" style="width: 100%" required>
                @foreach( $modes as $mode)
                    <option value="{{ $mode->id }}"> {{ $mode->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="paymentNote" value="{{ old('paymentNote') }}" placeholder="Payment Details / Notes">
        </div>

        <div class="custom-controls-stacked">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="paid"  value="1" checked >
                <span class="custom-control-label">Paid</span>
            </label>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="PaidAmount" value="{{ old('PaidAmount') }}" placeholder="Paid Amount">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="discount" value="{{ old('discount') }}" placeholder="Discount Amount">
        </div>

    </div>

</div>
