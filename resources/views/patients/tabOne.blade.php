<table class="table table-bordered table-hover" >
    <thead>
    <tr>
        <th>Date</th>
        <th>Pakage</th>
        <th>Days</th>
        <th>Amount</th>
        <th>Paid(Dis.)</th>
        <th>Balance</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if($patient->status == NULL)
        @foreach($patient->payments as $pay)

            <tr>
                <td style="padding: .5rem;">
                        <?php
                        $source = $pay->date;
                        $date = new DateTime($source);
                        ?>
                    {{ $date->format(" j M, y") }}

                </td>
                <td style="padding: .5rem;">
                    {{ $pay->title }}
                    @if($pay->active == 1)
                        <span ><i class="fa fa-circle" style="color:green" aria-hidden="true"></i></span>
                    @endif
                </td>
                <td style="padding: .5rem;"> {{ $pay->duration }}</td>
                <td style="padding: .5rem;"> Rs.{{ $pay->amount }}</td>
                <td style="padding: .5rem;"> Rs.{{ $pay->collections->sum('amount') }} @if($pay->collections->sum('discount'))({{ $pay->collections->sum('discount') }})@endif</td>
                <td style="padding: .5rem;"> Rs.{{ $pay->amount-($pay->collections->sum('amount')+$pay->collections->sum('discount')) }}</td>
{{--                <td>--}}

{{--                    @if($pay->collections->sum('refund'))--}}
{{--                        RF : <a href="{{ route('getRefundDetail',[ 'pid'=>$patient->id, 'payId' => $pay->id]) }}">{{ $pay->collections->sum('refund')}} </a>--}}
{{--                    @else--}}
{{--                        <div class="btn-group mt-2 mb-2">--}}
{{--                            @if($pay->collections->sum('amount')+$pay->collections->sum('discount') >= $pay->amount )--}}
{{--                                <button class="btn btn-outline-success btn-sm">--}}
{{--                                    Paid--}}
{{--                                </button>--}}
{{--                            @else--}}
{{--                                <a href="{{ route('collection.cr',['id' => $pay->id]) }}" class="btn btn-outline-danger btn-sm">--}}
{{--                                    <i class="fa fa-inr"></i> Pay--}}
{{--                                </a>--}}


{{--                            @endif--}}
{{--                            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown"  style="overflow-x: unset">--}}
{{--                                <span class="caret"></span>--}}
{{--                                <span class="sr-only">Toggle Dropdown</span>--}}
{{--                            </button>--}}
{{--                            <ul class="dropdown-menu text-center" role="menu">--}}
{{--                                <li>--}}
{{--                                    <div class="btn-group text-center">--}}
{{--                                        <a href="{{ route('payIndex',$pay->id) }}" class="btn btn-danger btn-sm">--}}
{{--                                            <i class="fa fa-search"></i>--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ route('editDate',$pay->id) }}" class="btn btn-danger btn-sm">--}}
{{--                                            <i class="fa fa-pencil"></i>--}}
{{--                                        </a>--}}

{{--                                        {{ Html()->form('DELETE')->route('payment.destroy', $pay->id)->open() }}--}}

{{--                                        <button type="submit" class="btn btn-danger btn-sm" onclick='--}}
{{--                                                                                    if(confirm("Are you sure?") == false) {--}}
{{--                                                                                        return false;--}}
{{--                                                                                    } else {--}}
{{--                                                                                        //--}}
{{--                                                                                    }'>--}}
{{--                                                <i class="fa fa-trash-o"></i>--}}
{{--                                            </button>--}}

{{--                                        {{ Html()->form()->close() }}--}}

{{--                                        @if($pay->active != 1)--}}
{{--                                            {{ Form::model($pay, array('route' => array('makeActive', $pay->id), 'method' => 'PATCH','style'=>'display:inline')) }}--}}
{{--                                            --}}
{{--                                            <input type="text" class="form-control" name="active" value="1" hidden>--}}
{{--                                            <button type="submit" class="btn btn-danger btn-sm">--}}
{{--                                                Activate--}}
{{--                                            </button>--}}
{{--                                            --}}
{{--                                        @endif--}}
{{--                                        <a href="{{ route('getRefund',['id' => $pay->id]) }}" class="btn btn-danger btn-sm">--}}
{{--                                            R--}}
{{--                                        </a>--}}



{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}

{{--                    @endif--}}

{{--                </td>--}}
                <td style="padding: .5rem;">
                    <div class="btn-group">
                        @if($pay->collections->sum('refund'))
                            RF : <a href="{{ route('getRefundDetail',[ 'pid'=>$patient->id, 'payId' => $pay->id]) }}">{{ $pay->collections->sum('refund')}} </a>
                        @else
                            @if($pay->collections->sum('amount')+$pay->collections->sum('discount') >= $pay->amount )
                                <button type="button" class="btn btn-success btn-xs"> Paid</button>
                            @else
                                <a href="{{ route('collection.cr',['id' => $pay->id]) }}" class="btn btn-success btn-xs"  data-toggle="tooltip" data-placement="top" title="Make Payment"> Pay</a>
                            @endif
                            @if($pay->active != 1)
                                    {{ Html()->form('PATCH')->route('users.update', $pay)->open() }}
                                    <input type="text" class="form-control" name="active" value="1" hidden>
                                        <button type="submit" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Make Active"><i class="fa fa-bolt"></i></button>
                                    {{ Html()->form()->close() }}
                            @endif
                            <a href="{{ route('payIndex',$pay->id) }}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="View Collection!"><i class="fa fa-search-dollar"></i></a>
                            <a href="{{ route('editDate',$pay->id) }}" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Date!"><i class="fa fa-pen-alt"></i></a>
                            <a href="{{ route('getRefund',['id' => $pay->id]) }}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Make Refund!"><i class="fa fa-reply"></i></a>

                                {{ Html()->form('DELETE')->route('payment.destroy', $pay->id)->open() }}
                                    <button type="submit" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Delete!" onclick='
                                                                                    if(confirm("Are you sure?") == false) {
                                                                                        return false;
                                                                                    } else {
                                                                                        //
                                                                                    }'>
                                        <i class="fa fa-trash" ></i>
                                    </button>
                                {{ Html()->form()->close() }}
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
