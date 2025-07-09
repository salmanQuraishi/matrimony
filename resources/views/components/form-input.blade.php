<div class="form-group @error($name) has-error has-feedback @enderror">
    @if ($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        class="form-control"
    >

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>