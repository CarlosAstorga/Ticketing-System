@props(['header' => ''])
<div {{ $attributes->merge(['class' => 'card-header']) }}>
    @if($slot->isNotEmpty()) {{ $slot }} @else {{ $header }} @endif
</div>