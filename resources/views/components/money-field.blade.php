<div class="field">
    <label for="{{ $name }}" class="label">
        {{ $label }}@if($attributes['required'])*@endif
    </label>
    <div class="control">
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="number"
            class="input @error($name) is-danger @enderror"
            placeholder="{{ $label }}@if($attributes['required'])*@endif"
            min="0.00"
            max="{{ config('money.decimal_max') }}"
            step="0.01"
            value="{{ old($name) ?? $attributes['value'] ?? '' }}"
            {{ $attributes }}
        >
    </div>
    @error($name)
    <p class="help is-danger">{{ $message }}</p>
    @enderror
    @isset($help)
        <p class="help">{{ $help }}</p>
    @endisset
</div>
