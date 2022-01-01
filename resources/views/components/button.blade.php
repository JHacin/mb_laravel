@php
    use Illuminate\View\ComponentAttributeBag;

    /** @var ComponentAttributeBag $attributes */
    /** @var callable $generateAttributes */
    $attributes = $generateAttributes($attributes);

    /** @var string $as */
    $tag = $as === 'link' ? 'a' : 'button';
@endphp

<{{ $tag }} {{ $attributes }}>

@if($icon && $iconPosition === 'start')
    <x-icon icon-class="{{ $icon }}"></x-icon>
@endif

{{-- Conditional render due to space-x-2 class --}}
@if(!$slot->isEmpty())
    <span>{{ $slot }}</span>
@endif

</{{$tag}}>
