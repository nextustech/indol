@props(['step', 'title', 'status' => 'upcoming'])
<div class="step-pill {{ $status }}" data-step="{{ $step }}">
    <span class="step-pill__index">
        @if($status === 'completed')
            <span class="step-pill__check">&#10003;</span>
        @else
            {{ $step }}
        @endif
    </span>
    <div>
        <div class="step-pill__title">{{ $title }}</div>
    </div>
</div>
