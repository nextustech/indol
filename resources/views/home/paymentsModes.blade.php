@foreach( $paymentModes->chunk(3) as $paymentModesChunk )
    <div class="row">

        @if(count($paymentModesChunk) < 5)
                <?php
                if(!(count($paymentModesChunk))){
                    $dby = 1;
                }else{
                    $dby = count($paymentModesChunk);
                }

                $mdNo = 12 / $dby; ?>
        @endif
        @foreach( $paymentModesChunk as $paymentMode )

            <div class="col-md-{{$mdNo}}">

                <a href="{{ route('collectionDetail',$paymentMode->id) }}" class="btn btn-block btn-app bg-secondary">
                    {{ $paymentMode->name }}
                    <span class="badge bg-gradient-indigo">{{ $paymentMode->collections->count() }}</span>
                    <span class="btn btn-block btn-success">₹.{{ $paymentMode->collections->sum('amount') }}</span>
                </a>
            </div>
        @endforeach

    </div><br/>
@endforeach
<br/>
