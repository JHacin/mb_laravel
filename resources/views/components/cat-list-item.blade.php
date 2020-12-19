@php
    use App\Models\Cat;
    use App\Utilities\AgeFormat;
    use Carbon\Carbon;

    $fallback = '/';

    /** @var Cat $cat */
    $dateOfArrivalBoter = $cat->date_of_arrival_boter
        ? $cat->date_of_arrival_boter->format(config('date.format.default'))
        : $fallback;

    $currentAge = $cat->date_of_birth
        ? AgeFormat::formatToAgeString($cat->date_of_birth->diff(Carbon::now()))
        : $fallback
@endphp

<div class="card" dusk="cat-list-item">
    <div class="card-image">
        <figure class="image is-1by1">
            <img src="{{ $cat->first_photo_url }}" alt="{{ $cat->name }}">
        </figure>
    </div>

    <div class="card-content">
        <div class="media">
            <div class="media-content">
                <p class="title is-4" dusk="cat-list-item-{{ $cat->id }}-name">{{ $cat->name }}</p>
            </div>
        </div>

        <div class="content">
            <p>
                <span>Trenutno botrov:</span>
                <strong dusk="cat-list-item-{{ $cat->id }}-sponsorship-count">{{ $cat->sponsorships_count }}</strong>
            </p>

            <p>
                <span>Datum vstopa v botrstvo:</span>
                <strong dusk="cat-list-item-{{ $cat->id }}-date-of-arrival-boter">{{ $dateOfArrivalBoter }}</strong>
            </p>

            <p>
                <span>Trenutna starost:</span>
                <strong dusk="cat-list-item-{{ $cat->id }}-current-age">{{ $currentAge }}</strong>
            </p>
        </div>
    </div>

    <footer class="card-footer">
        <a
            href="{{ route('cat_details', $cat) }}"
            class="card-footer-item"
            dusk="cat-list-item-{{ $cat->id }}-details-link"
        >
            Preberi mojo zgodbo
        </a>
        <a
            href="{{ route('become_cat_sponsor', $cat) }}"
            class="card-footer-item"
            dusk="cat-list-item-{{ $cat->id }}-sponsorship-form-link"
        >
            Postani moj boter
        </a>
    </footer>
</div>
