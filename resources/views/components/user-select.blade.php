@php
    $selectedValue = $selected ?? old($name);
@endphp

<div class="form-group @error($name) has-error has-feedback @enderror">
    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-select form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
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