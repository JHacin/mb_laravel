@php
    use App\Models\PersonData;

    /** @var PersonData $sponsor */
    $first_name = $sponsor->first_name ?? 'brez imena';
    $city = $sponsor->city ?? 'neznan kraj'
@endphp

<div
  {{ $attributes }}
  dusk="sponsor-details-{{ $sponsor->id }}"
>
    <span @class(['italic' => !$sponsor->first_name])>{{ $first_name }}</span>,
    <small @class(['italic' => !$sponsor->city])>{{ $city }}</small>
</div>
