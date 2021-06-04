@props(['header'])
<div {{ $attributes->merge(['class' => 'card-header']) }}>
    {{ $header }}
</div>