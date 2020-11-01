<div class="field">
    <label for="{{ $name }}" class="label">
        {{ $label }}@if($attributes['required'])*@endif
    </label>
    <div class="control">
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="number"
            class="input"
            placeholder="{{ $label }}@if($attributes['required'])*@endif"
            min="0.00"
            max="{{ config('money.decimal_max') }}"
            step="0.01"
            {{ $attributes }}
        >
    </div>
    @isset($help)
        <p class="help">{{ $help }}</p>
    @endisset
</div>
