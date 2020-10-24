@php
    use App\Models\Cat;
    use App\Models\CatPhoto;

    /** @var Cat $entry */
    $cat = $entry;
    $url = $cat->first_photo_url;
@endphp

<span>
    @if(empty($url))
        -
    @else
        <a href="{{ $url }}" target="_blank">
            <img src="{{ $url }}" style="max-height: 35px; width: auto; border-radius: 3px;" alt="{{ $cat->name }}" />
        </a>
    @endif
</span>
