@props([
    'id',
    'name',
    'label' => '',
    'rows' => 3,
    'value' => '',
    'placeholder' => '',
    'readonly' => false,
    'disabled' => false,
])

<div class="form-group @error($name) has-error has-feedback @enderror">
    @if ($label)
        <label for="{{ $id }}">
            {{ $label }}
        </label>
    @endif

    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>