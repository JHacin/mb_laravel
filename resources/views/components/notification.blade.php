@props(['type', 'message'])

<div class="notification is-{{ $type }} is-light">
    <button type="button" class="delete"></button>
    {{ $message }}
</div>
