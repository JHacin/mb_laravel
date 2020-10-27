@php
    use App\View\Components\SponsorDetails;

    /** @var string $first_name */
    $is_missing_first_name = $first_name === SponsorDetails::MISSING_FIRST_NAME_PLACEHOLDER;

    /** @var string $city */
    $is_missing_city = $city === SponsorDetails::MISSING_CITY_PLACEHOLDER
@endphp

<div>
    <span class="{{ $is_missing_first_name ? 'is-italic' : '' }}">{{ $first_name }}</span>,
    <span class="{{ $is_missing_city ? 'is-italic' : '' }}">{{ $city }}</span>
</div>
