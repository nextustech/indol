                    <div class="row bx dt">
                        <div class="col-md-12">
                            
                          {{ Html()->form('POST')->route('schedules.store')->style('display:inline')->open() }}
                            @if($active)
                            <input type="text" class="form-control" name="patient_id" value="{{ $active->patient_id }}" hidden>
                            <input type="text" class="form-control" name="payment_id" value="{{ $active->id }}" hidden>
                            <input type="text" class="form-control" name="package_id" value="{{ $active->pakage_id }}" hidden>

                                <div class="card-header">
                                    <h3 class="card-title">Add Schedule</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Date</label>
                                                <input type="date" class="form-control  fc-datepicker" required name="date"  placeholder="Date" >
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="form-control" required name="title" placeholder="Sitting Title" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="padding-top:32px;">
                                       			<label class="form-label"></label>
                                                <button type="submit" class="btn btn-primary">ADD Sitting</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">

                                </div>
                            @endif
                            {{ Html()->form()->close() }}

                        </div>
                    </div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-green card-outline" style="padding: .25rem; font-size:12px;">
            <div class="card-header">
                <h3 class="card-title">Schedule( Attended Sessions - {{ $attendedSittings }} )</h3>
                <a href="{{ route('scheduleP',$patient->id) }}" class="btn btn-danger btn-sm">
                    <i class="fa fa-print"></i>
                </a>
				@can('addSittings')
                <div class="card-tools" style="display: inline-block">
                    <div class="input-group input-group-sm">
                        <div class="input-group-append">
{{--                        <input type="checkbox" class="form-control" name="schedule" id="schedule" value="dt" >--}}
                            <div class="icheck-primary">
                                <input type="checkbox" value="dt" name="schedule"  id="schedule">
                                <label for="schedule">Add Sittings .</label>
                            </div>
{{--                            <div class="btn btn-primary">--}}
{{--                                Add Sittings--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
                <!-- /.card-tools -->
              @endcan
            </div>
            <div class="card-body" style="padding: .25rem; font-size:12px;">

                <div class="table-responsive">
                    <table class="table card-table table-vcenter border text-nowrap">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Sitting No.</th>
                            <th>Treatment</th>
                            <th>Action</th>
                            <th>Balance Rs.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $d = 1;
                        ?>
                        @if($schedules)
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td>
                                            <?php
                                            $source = $schedule->sittingDate;
                                            $date = new DateTime($source);
                                            ?>
                                        {{ $date->format(" j M, y l") }}
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm">
                                            {{ $schedule->title }}
                                        </button>


                                    </td>
                                    <td>
                                        @if($schedule->treatment)
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="{{  $schedule->treatment }}">
                                                                    Detail</a>
                                            
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$schedule->status)
                                            @if(!$schedule->attendedAt)
                                                    <?php
                                                    $ndt = Carbon\carbon::parse($schedule->sittingDate);
                                                    $sittingDate = $ndt->format('Y-m-d');
                                                    ?>

                                                @if($dt>$sittingDate)
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="dropdown">
                                                            <i class="fa fa-calendar-check"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
{{--                                                                            {{ Form::model($schedule, array('route' => array('schedules.update', $schedule->id), 'method' => 'PATCH','style'=>'display:inline')) }}--}}
                                                                            {{ Html()->form('PATCH')->route('schedules.update', $schedule)->style('display:inline')->open() }}
                                                                            <div class="form-group">
                                                                                <input type="date" class="form-control fc-datepicker" name="date" placeholder="MM/DD/YYYY" autocomplete="off">
                                                                            </div>

                                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                                <i class="fa fa-plus-square"></i> Add
                                                                            </button>
                                                                            {{ Html()->form('PATCH')->close() }}

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </li>
                                                        </ul>
                                                    </div>

{{--                                                    {{ Form::model($schedule, array('route' => array('schedules.update', $schedule->id), 'method' => 'PATCH','style'=>'display:inline')) }}--}}
                                                    {{ Html()->form('PATCH')->route('schedules.update', $schedule)->style('display:inline')->open() }}
                                                    <input type="text" class="form-control" name="attendedAt" value="<?php echo \Carbon\Carbon::now(); ?>" hidden>
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        Make Attended
                                                    </button>
                                                    {{ Html()->form()->close() }}
                                                @else
                                                    <button class="btn btn-outline-danger btn-sm">
                                                        Make Attended
                                                    </button>
                                                @endif
                                            @else
                                                    <?php
                                                    $date2 = new DateTime($schedule->attendedAt);
                                                    ?>
                                                @if($schedule->attendedAt)
                                                    <button class="btn btn-success btn-sm">
                                                        {{  $date2->format(" j M, y,G:i") }}
                                                    </button>
                                                    {{ Html()->form('PATCH')->route('revertAbsent', $schedule)->style('display:inline')->open() }}
                                                    <input type="text" class="form-control" name="attendedAt" value="" hidden>
                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-undo"></i>
                                                    </button>
                                                    {{ Html()->form()->close() }}
                                                @endif
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="dropdown">
                                                        <i class="fa fa-calendar-check"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-12">
{{--                                                                        {{ Form::model($schedule, array('route' => array('schedules.update', $schedule->id), 'method' => 'PATCH','style'=>'display:inline')) }}--}}
                                                                        {{ Html()->form('PATCH')->route('schedules.update', $schedule)->style('display:inline')->open() }}
                                                                        <div class="form-group">
                                                                            <input type="date" class="form-control fc-datepicker" name="date" placeholder="MM/DD/YYYY" autocomplete="off">
                                                                        </div>

                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                            <i class="fa fa-plus-square"></i> Add
                                                                        </button>
                                                                        {{ Html()->form()->close() }}
{{--                                                                        {!! Form::close() !!}--}}

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </li>
                                                    </ul>
                                                </div>


                                                <a href="{{ route('schedules.edit',$schedule->id) }}" data-toggle="modal" data-target="#exampleModal-{{ $schedule->id }}" >
                                                    <button type="button" class="btn btn-danger btn-sm" >
                                                        <i class="fa fa-medkit"></i>
                                                    </button>
                                                </a>
                                                
{{--                                                    {!! Form::open(['method' => 'DELETE','route' => ['schedules.destroy', $schedule->id],'style'=>'display:inline']) !!}--}}
                                     		 @can('deleteSession')
                                                    {{ Html()->form('DELETE')->route('schedules.destroy', $schedule)->style('display:inline')->open() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick='
                                                                    if(confirm("Are you sure?") == false) {
                                                                        return false;
                                                                    } else {
                                                                        //
                                                                    }'>
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    {{ Html()->form()->close() }}
                                             @endcan
                                                <div class="modal fade" id="exampleModal-{{ $schedule->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Treatment Details</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">x</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ Html()->form('PATCH')->route('schedules.update', $schedule)->style('display:inline')->open() }}
                                                                <textarea  class="form-control" name="treatment" id="exampleFormControlTextarea1" cols="50" rows="10"></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                                {{ Html()->form('PATCH')->close() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal -->

                                            @endif
                                            @if(!$schedule->attendedAt)
                                                    {{ Html()->form('PATCH')->route('makeAbsent', $schedule)->style('display:inline')->open() }}
                                                    <input type="text" class="form-control" name="status" value="2" hidden>
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                    AB
                                                </button>
                                                {{ Html()->form()->close() }}
                                            @endif
                                        @else
                                            <button type="submit" class="btn btn-danger-outline btn-sm">AB</button>
                                      
                                      {{ Html()->form('PATCH')->route('revertAbsent', $schedule)->style('display:inline')->open() }}
    									<input type="text" class="form-control" name="status" value="" hidden>
            								<button type="submit" class="btn btn-warning btn-sm">
                								<i class="fa fa-undo"></i>
											</button>
										{{ Html()->form()->close() }}
                                        @endif
                                    </td>
                                    <td>
									@can('PatientCollectionView') 
                                            @if($schedule->attendedAt)
                                                        <?php
                                                        if($schedule->payment->duration<1){
                                                            $timePeriod = 1;
                                                        }else{
                                                            if($schedule->payment->perDaySittings > 0){
                                                                $timePeriod = $schedule->payment->duration * $schedule->payment->perDaySittings;
                                                            }else{
                                                                $timePeriod = $schedule->payment->duration;
                                                            }
                                                        }
                                                        $actualPaidAmount = $schedule->payment->amount - $pay->collections->sum('discount');
                                                        $bal= $actualPaidAmount - (($actualPaidAmount/$timePeriod)*$d++) ?>
                                                    Rs.{{ round($bal,2) }}

                                            @endif
									@endcan
                                    </td>
                                </tr>
                                <!-- Modal -->

                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">There Is No Active Package Please Activate Package to Show Schedule</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
