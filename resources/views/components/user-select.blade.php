@php
    $selectedValue = $selected ?? old($name);
@endphp

<div class="form-group @error($name) has-error has-feedback @enderror">
    <label for="{{ $id }}">{{ $label }}</label>
    <select class="form-select form-control" id="{{ $id }}" name="{{ $name }}">
        <option value="{{ $label }}">{{ $label }}</option>
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