@php
    use App\Utilities\AgeFormat;
    use Carbon\Carbon;

    $fallback = '/';

    $dateOfArrivalBoter = $cat->date_of_arrival_boter
        ? $cat->date_of_arrival_boter->format(config('date.format.default'))
        : $fallback;

    $currentAge = $cat->date_of_birth
        ? AgeFormat::formatToAgeString($cat->date_of_birth->diff(Carbon::now()))
        : $fallback
@endphp

<div class="card">
    <div class="card-image">
        <figure class="image is-1by1">
            <img src="{{ $cat->first_photo_url }}" alt="{{ $cat->name }}">
        </figure>
    </div>

    <div class="card-content">
        <div class="media">
            <div class="media-content">
                <p class="title is-4">{{ $cat->name }}</p>
            </div>
        </div>

        <div class="content">
            <p>
                <span>Trenutno botrov:</span>
                <strong>{{ $cat->sponsorships_count }}</strong>
            </p>

            <p>
                <span>Datum vstopa v botrstvo:</span>
                <strong>{{ $dateOfArrivalBoter }}</strong>
            </p>

            <p>
                <span>Trenutna starost:</span>
                <strong>{{ $currentAge }}</strong>
            </p>
        </div>
    </div>

    <footer class="card-footer">
        <a
            href="{{ route('cat_details', $cat) }}"
            class="card-footer-item"
        >
            Preberi mojo zgodbo
        </a>
        <a
            href="{{ route('become_cat_sponsor', $cat) }}"
            class="card-footer-item"
        >
            Postani moj boter
        </a>
    </footer>
</div>
