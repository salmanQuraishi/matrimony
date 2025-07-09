<div class="form-group  @error($name) has-error has-feedback @enderror">
    <label for="{{ $id }}">Status</label>
    <select class="form-select form-control" id="{{ $id }}" name="{{ $name }}">
        <option value="" selected disabled>Choose a Status</option>
        <option value="show" {{ old($name, $selected) == 'show' ? 'selected' : '' }}>Show</option>
        <option value="hide" {{ old($name, $selected) == 'hide' ? 'selected' : '' }}>Hide</option>
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>