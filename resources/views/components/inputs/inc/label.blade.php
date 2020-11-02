@isset($label)
    <label for="{{ $name }}" class="label">
        {{ $label }}
        @if($attributes['required'])<span class="has-text-primary">*</span>@endif
    </label>
@endisset
