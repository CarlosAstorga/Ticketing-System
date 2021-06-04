@props(['label', 'name', 'value' => '', 'type' => 'text', 'errorBag' => 'default'])

<div class="row mb-3">
    <label for="{{ $name }}" class="col-12 col-sm-3 text-sm-end mb-2 mb-lg-0 fw-bold py-sm-2">
        {{ $label }}
    </label>
    <div class="col-12 col-sm-8 col-lg-7">
        @if ($slot->isNotEmpty())
        {{ $slot }}
        @else
        @switch($type)
        @case('textarea')
        <textarea id="{{ $name }}" style="resize: none;" class='form-control @error("{$name}", "{$errorBag}") is-invalid @enderror' name="{{ $name }}" autocomplete="{{ $name }}" maxlength="150">{{ old($name, $value) }}</textarea>
        @break

        @default
        <input id="{{ $name }}" type="{{ $type }}" class='form-control @error("{$name}", "{$errorBag}") is-invalid @enderror' name="{{ $name }}" autofocus maxlength="100" @if(isset($value)) value='{{ old("{$name}", "{$value}") }}' @endif>
        @endswitch

        @error("{$name}", "{$errorBag}")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @endif
    </div>
</div>