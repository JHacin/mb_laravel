@isset($label)
    <label
        for="{{ $name }}"
        class="mb-input-label"
    >
        {{ $label }}
        @if ($attributes['required'])
            <span class="has-text-primary">*</span>
        @endif
    </label>
@endisset
