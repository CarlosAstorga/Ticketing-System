@props(['title', 'text'])
<div {{ $attributes->merge(['class' => 'row']) }}>
    <p class="fs-6 col-12 col-sm-3 col-lg-2 text-sm-end mb-2 mb-lg-0 fw-bold py-sm-2">{{ $title }}</p>
    <p class="fs-6 col-12 col-sm-8 col-lg-9 mb-2 mb-lg-0 py-sm-2">{{ $text }}</p>
</div>