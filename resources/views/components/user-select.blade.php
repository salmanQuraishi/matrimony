@props([
    'label' => '',
    'id' => '',
    'name',
    'options' => [],
    'selected' => null,
    'disabled' => false,
])

@php
    $selectedValue = $selected ?? old($name);
    $selectId = $id ?: $name;
@endphp

<div class="form-group @error($name) has-error has-feedback @enderror">
    @if($label)
        <label for="{{ $selectId }}">{{ $label }}</label>
    @endif

    <select
        id="{{ $selectId }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-select form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
        @if($disabled) disabled @endif
    >
        <option value="" selected disabled>{{ $label }}</option>
        @foreach($options as $option)
            @php
                $optionValue = is_object($option) ? $option->id : $option;
                $optionText = is_object($option) ? $option->name : $option;
            @endphp
            <option value="{{ $optionValue }}" {{ $selectedValue == $optionValue ? 'selected' : '' }}>
                {{ $optionText }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>