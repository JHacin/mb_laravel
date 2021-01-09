<div
    class="cat-list-item card is-flex-grow-1 is-flex is-flex-direction-column"
    dusk="cat-list-item"
    data-cat-id="{{ $cat->id }}"
>
    <div class="cat-list-item-image-wrapper card-image">
        <figure class="image is-1by1">
            <img src="{{ $cat->first_photo_url }}" alt="{{ $cat->name }}">
        </figure>
    </div>

    <div class="card-content is-flex-grow-1 is-flex is-flex-direction-column">
        <h5 class="title is-5" dusk="cat-list-item-name">{{ $cat->name }}</h5>

        <div class="mb-2">
            <span>Trenutno botrov:</span>
            <strong dusk="cat-list-item-sponsorship-count">{{ $cat->sponsorships_count }}</strong>
        </div>

        <div class="mb-2">
            <span>Datum vstopa v botrstvo:</span>
            <div>
                <strong dusk="cat-list-item-date-of-arrival-boter">{{ $dateOfArrivalBoter }}</strong>
            </div>
        </div>

        <div class="mb-4">
            <span>Trenutna starost:</span>
            <div>
                <strong dusk="cat-list-item-current-age">{{ $currentAge }}</strong>
            </div>
        </div>

        <div style="margin-top: auto;">
            <div class="mb-2">
                <a
                    class="is-flex is-align-items-center has-text-weight-semibold has-text-secondary"
                    href="{{ route('cat_details', $cat) }}"
                    dusk="cat-list-item-details-link"
                >
                    <span class="icon is-justify-content-flex-start">
                        <i class="fas fa-arrow-circle-right"></i>
                    </span>
                    <span>Preberi mojo zgodbo</span>
                </a>
            </div>

            <div>
                <a
                    class="is-flex is-align-items-center has-text-weight-semibold has-text-primary"
                    href="{{ route('become_cat_sponsor', $cat) }}"
                    dusk="cat-list-item-sponsorship-form-link"
                >
                    <span class="icon is-justify-content-flex-start">
                        <i class="fas fa-arrow-circle-right"></i>
                    </span>
                    <span>Postani moj boter</span>
                </a>
            </div>
        </div>
    </div>
</div>
