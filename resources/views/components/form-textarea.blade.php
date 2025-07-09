<div class="form-group @error($name) has-error has-feedback @enderror">
    @if($label)
        <label for="{{ $id }}">
            {{ $label }}
        </label>
    @endif

    <textarea
        class="form-control @error($name) is-invalid @enderror"
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>