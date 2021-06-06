@props(['label', 'name', 'value' => '', 'type' => 'text', 'errorBag' => 'default', 'catalog', 'field' => 'title', 'required' => true])

<div {{ $attributes->merge(['class' => 'row']) }}>
    <label for="{{ $name }}" class="col-12 col-sm-3 col-lg-2 text-sm-end mb-2 mb-lg-0 fw-bold py-sm-2">
        {{ $label }}
        @if($required) <span class="text-blue">*</span> @endif
    </label>
    <div class="col-12 col-sm-8 col-lg-9">
        @if ($slot->isNotEmpty())
        {{ $slot }}
        @else
        @switch($type)
        @case('textarea')
        <textarea id="{{ $name }}" style="resize: none;" class='form-control @error("{$name}", "{$errorBag}") is-invalid @enderror' name="{{ $name }}" autocomplete="{{ $name }}" maxlength="150">{{ old($name, $value) }}</textarea>
        @break

        @case('date')
        <input id="{{ $name }}" class='form-control @error("{$name}", "{$errorBag}") is-invalid @enderror' type="{{ $type }}" name="{{ $name }}" min="{{ date('Y-m-d') }}" @if(isset($value)) value='{{ old("{$name}", explode(" ", "{$value}")[0]) }}' @endif>
        @break

        @case('select')
        <select name="{{ $name }}" class='form-control @error("{$name}", "{$errorBag}") is-invalid @enderror' id="{{ $name }}">
            @foreach($catalog as $item)
            @if (old($name) == $item->id)
            <option value="{{ $item->id }}" selected>
                {{ $item->$field }}
            </option>
            @elseif ($value == $item->id && old("{$name}") == null)
            <option value="{{ $item->id }}" selected>
                {{ $item->$field}}
            </option>
            @else
            <option value="{{ $item->id }}">
                {{ $item->$field}}
            </option>
            @endif
            @endforeach
        </select>
        @break

        @default
        <input id="{{ $name }}" class='form-control @error("{$name}", "{$errorBag}") is-invalid @enderror' type="{{ $type }}" name="{{ $name }}" autofocus maxlength="100" @if(isset($value)) value='{{ old("{$name}", "{$value}") }}' @endif>
        @endswitch

        @error("{$name}", "{$errorBag}")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @endif
    </div>
</div>