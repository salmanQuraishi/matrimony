@props([
    'type' => 'text',
    'id' => '',
    'name',
    'label' => '',
    'value' => '',
    'placeholder' => '',
])

@php
    $inputId = $id ?: $name;
    $hasError = $errors->has($name);
@endphp

<div class="form-group @error($name) has-error has-feedback @enderror">
    @if ($label)
        <label for="{{ $inputId }}">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $inputId }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'form-control' . ($hasError ? ' is-invalid' : '')]) }}
    >

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>