<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control select2" name="branch_id" data-placeholder="Choose Branch">
                        <option value="" selected> Select Branch </option>
                        @foreach( $user->branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id  ? 'selected':'' }}>
                                    {{ $branch->branchName }}
                                </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php
                    use App\Models\ServiceType;
                    $user = Auth::user();
                    $services = ServiceType::all();
                    ?>
                    <select class="form-control select2" id="serviceType" name="service_type_id" data-placeholder="Choose Package">
                        <option value="" selected> Select Service </option>
                        @foreach( $services as $service)
                                <option value="{{ $service->id }}" {{ old('service_type_id') == $service->id  ? 'selected':'' }}>
                                    {{ $service->name }}
                                </option>
                        @endforeach
                    </select>
                </div>

            </div>

        </div>
        @can('BackDateEntry')
        <div class="form-group">
            <input type="date" class="form-control fc-datepicker" name="date" value="{{ old('date') }}" placeholder="Registration Date ( DD/MM/YYYY )" autocomplete="off">
        </div>
        @else
        <div class="form-group">
            <input type="text" class="form-control fc-datepicker" id="datepicker1" name="date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" readonly placeholder="Registration Date ( DD/MM/YYYY )" autocomplete="off">
        </div>
        @endcan
        <div class="form-group">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name" placeholder="Enter Name Here">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="age" value="{{ old('age') }}" id="age" placeholder="Enter Age Here">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control select2" name="gender" data-placeholder="Choose Gender">
                        <option value="" selected> </option>
                        <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>
                            Male
                        </option>
                        <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>
                            Female
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" id="mobile" placeholder="Enter Mobile No. Here">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="amount" value="{{ old('amount') }}" id="amount" placeholder="Enter amount Here">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="days" value="{{ old('days') }}" id="days" placeholder="Enter days Here">
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="serviceTitle" name="title" value="{{ old('title') }}" placeholder="Enter Package Title">
        </div>
        <div class="custom-controls-stacked">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="schedule" id="schedule" value="dt" >
                <span class="custom-control-label">Create Schedule</span>
            </label>
        </div>
        <div id="bx">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group bx dt">
                        <label for="from">From Date</label>
                        <input type="date" class="form-control fc-datepicker" name="from" value="{{ old('from') }}" placeholder="MM/DD/YYYY" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group bx dt">
                        <label for="dailyVisits">Sessions Per Day</label>
                        <input type="number" class="form-control" name="dailyVisits" value="{{ old('dailyVisits', 1) }}" min="1" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group bx dt">
                        <label>Total Sessions</label>
                        <input type="number" class="form-control" name="total_sessions" value="{{ old('total_sessions') }}" min="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group bx dt">
                        <label>Saturday Sessions</label>
                        <input type="number" class="form-control" name="saturday_sittings" value="{{ old('saturday_sittings') }}" placeholder="Optional override" min="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group bx dt">
                        <label>Sunday Sessions</label>
                        <input type="number" class="form-control" name="sunday_sittings" value="{{ old('sunday_sittings', 0) }}" min="0">
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-3">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="ptype"  value="1">
                            <span class="custom-control-label">Post Paid</span>
                        </label>
                    </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <input type="text" class="form-control" name="ref_by" value="{{ old('ref_by') }}" placeholder="Referred By">
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="diagnosis" value="{{ old('diagnosis') }}" placeholder="Diagnosis">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="address" id="exampleFormControlTextarea2" rows="1" placeholder="Write Address here ..."></textarea>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="otherNotes" id="exampleFormControlTextarea1" rows="1" placeholder="Write Other Description ( If Any ) here ..."></textarea>
        </div>
        <div class="form-group">
            <select class="form-control select2" name="cash" data-placeholder="Choose Payment Method" style="width: 100%" required>
                <?php
                $modes = \App\Models\Mode::all();
                ?>
                @foreach( $modes as $mode)
                    <option value="{{ $mode->id }}"> {{ $mode->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="paymentNote" value="{{ old('paymentNote') }}" placeholder="Payment Details / Notes">
        </div>
        <div class="row">
            <div class="col-md-2">
            <div class="custom-controls-stacked">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="paid"  value="1" checked >
                    <span class="custom-control-label">Paid</span>
                </label>
            </div>
            </div>
            <div class="col-md-5">
            <div class="form-group">
                <input type="text" class="form-control" name="PaidAmount" value="{{ old('PaidAmount') }}" placeholder="Paid Amount">
            </div>
            </div>
           @can('discount')
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control" name="discount" value="{{ old('discount') }}" placeholder="Discount Amount">
                </div>
            </div>
			@endcan
        </div>


    </div>
</div>
