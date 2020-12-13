@php
    use App\Models\PersonData;

    /** @var PersonData $sponsor */
    $first_name = $sponsor->first_name ?? 'brez imena';
    $city = $sponsor->city ?? 'neznan kraj'
@endphp

<div dusk="sponsor-details-{{ $sponsor->id }}">
    <span class="{{ !$sponsor->first_name ? 'is-italic' : '' }}">{{ $first_name }}</span>,
    <span class="{{ !$sponsor->city ? 'is-italic' : '' }}">{{ $city }}</span>
</div>
