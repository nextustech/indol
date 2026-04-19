@foreach($paymentModes->chunk(3) as $chunk)
    <div class="row">

        @php
            $count = $chunk->count();
            $mdNo = $count ? intdiv(12, $count) : 12;


            $year = now()->year;
            $month = now()->month;

            if ($month >= 4) {
                $fy = $year . '-' . ($year + 1);
            } else {
                $fy = ($year - 1) . '-' . $year;
            }
        @endphp
        @foreach($chunk as $paymentMode)
            <div class="col-md-{{ $mdNo }}">
                <a href="{{ route('collectionDetail', $paymentMode->id) }}"
                   class="btn btn-block btn-app bg-secondary">

                    {{ $paymentMode->name }}

                    {{-- ✅ Use aggregated count (NO memory issue) --}}
                    <span class="badge bg-gradient-indigo">
                        {{ $paymentMode->today_count ?? 0 }}
                    </span>

                    {{-- ✅ Safe total --}}
                    <span class="btn btn-block btn-success">
                        ₹ {{ number_format($paymentMode->today_total ?? 0, 2) }}
                    </span>

                </a>
            </div>
        @endforeach

    </div>
    <br/>
@endforeach
<br/>
