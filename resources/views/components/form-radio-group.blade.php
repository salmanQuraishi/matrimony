@props([
    'label' => '',
    'name',
    'options' => [],
    'selected' => null
])

<div class="form-group @error($name) has-error has-feedback @enderror">
    @if ($label)
        <label class="form-label d-block">{{ $label }}</label>
    @endif

    <div class="d-flex">
        @foreach ($options as $value => $text)
            <div class="form-check" style="padding:0px !important;padding-left: 0px !important">
                <input
                    type="radio"
                    id="{{ $name }}_{{ $value }}"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    {{ $selected == $value ? 'checked' : '' }}
                    {{ $attributes->class('form-check-input') }}
                >
                <label class="form-check-label" for="{{ $name }}_{{ $value }}">
                    {{ $text }}
                </label>
            </div>
        @endforeach
    </div>

    @error($name)
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>