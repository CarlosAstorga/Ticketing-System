@props(['type' => 'info', 'message'])

<div {{ $attributes->merge(['class' => 'alert-dismissible fade show alert alert-'. $type]) }}>
    <strong>Holy guacamole!</strong> {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>