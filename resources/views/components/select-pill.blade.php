@props(['id', 'label', 'selected' => false])
<button type="button" class="select-pill {{ $selected ? 'active' : '' }}" data-id="{{ $id }}">
    <span class="select-pill__icon">📍</span>
    <span class="select-pill__label">{{ $label }}</span>
</button>
