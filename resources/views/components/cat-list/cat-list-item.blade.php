<div
    class="cat-list-item {{ $cat->is_group ? 'cat-list-item--group' : '' }} card is-flex-grow-1 is-flex is-flex-direction-column"
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

        <div class="mb-4">
            <div class="mb-2">
                <span>Trenutno botrov:</span>
                    <span class="has-text-weight-semibold" dusk="cat-list-item-sponsorship-count">
                    {{ $cat->sponsorships_count }}
                </span>
            </div>

            @if(!$cat->is_group)
                <div class="mb-2">
                    <span>Datum vstopa v botrstvo:</span>
                    <div class="has-text-weight-semibold" dusk="cat-list-item-date-of-arrival-boter">
                        {{ $dateOfArrivalBoter }}
                    </div>
                </div>

                <div class="mb-2">
                    <span>Trenutna starost:</span>
                    <div class="has-text-weight-semibold" dusk="cat-list-item-current-age">
                        {{ $currentAge }}
                    </div>
                </div>
            @endif
        </div>

        <div style="margin-top: auto;">
            <div class="mb-2">
                <a
                    class="cat-list-item__link is-flex is-align-items-center has-text-weight-semibold has-text-secondary"
                    href="{{ route('cat_details', $cat) }}"
                    dusk="cat-list-item-details-link"
                >
                    <span class="icon is-justify-content-flex-start">
                        <i class="fas fa-arrow-circle-right"></i>
                    </span>
                    <span>
                        @if($cat->is_group)
                            Preberi več
                        @else
                            Preberi mojo zgodbo
                        @endif
                    </span>
                </a>
            </div>

            <div>
                @if($cat->status === \App\Models\Cat::STATUS_TEMP_NOT_SEEKING_SPONSORS)
                    <em>{{ trans('cat.temp_not_seeking_sponsors_text') }}</em>
                @else
                    <a
                        class="cat-list-item__link is-flex is-align-items-center has-text-weight-semibold has-text-primary"
                        href="{{ route('become_cat_sponsor', $cat) }}"
                        dusk="cat-list-item-sponsorship-form-link"
                    >
                    <span class="icon is-justify-content-flex-start">
                        <i class="fas fa-arrow-circle-right"></i>
                    </span>
                        <span>
                        @if($cat->is_group)
                                Postani boter
                            @else
                                Postani moj boter
                            @endif
                    </span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
