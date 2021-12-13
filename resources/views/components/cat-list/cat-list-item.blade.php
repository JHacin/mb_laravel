<div
    class="tw-shadow-xl tw-border-2 tw-rounded-xl
           tw-flex-grow is-flex tw-flex tw-flex-col tw-overflow-hidden
           {{ $cat->is_group ? 'tw-text-white' : 'tw-text-black' }}
           {{ $cat->is_group ? 'tw-border-primary' : 'tw-border-secondary' }}
           {{ $cat->is_group ? 'tw-bg-primary' : 'tw-bg-secondary' }}"
    dusk="cat-list-item"
    data-cat-id="{{ $cat->id }}"
>
    <div
      class="tw-border-b-2 tw-block tw-relative
             {{ $cat->is_group ? 'tw-border-primary' : 'tw-border-secondary' }}"
    >
        <figure class="tw-block tw-relative tw-pt-[100%]">
            <img
              class="tw-block tw-max-w-full tw-absolute tw-top-0 tw-left-0 tw-right-0 tw-bottom-0 tw-h-full tw-w-full"
              src="{{ $cat->first_photo_url }}"
              alt="{{ $cat->name }}"
            >
        </figure>
    </div>

    <div class="tw-p-6 tw-flex-grow tw-flex tw-flex-col {{ $cat->is_group ? 'tw-bg-primary' : 'tw-bg-white' }}">
        <h5
          class="tw-font-bold tw-text-xl tw-mb-3 {{ $cat->is_group ? 'tw-text-white' : 'tw-text-secondary' }}"
          dusk="cat-list-item-name"
        >{{ $cat->name }}</h5>

        <div class="tw-mb-4">
            <div class="tw-mb-2">
                <span>Trenutno botrov:</span>
                    <span class="tw-font-semibold" dusk="cat-list-item-sponsorship-count">
                    {{ $cat->sponsorships_count }}
                </span>
            </div>

            @if(!$cat->is_group)
                <div class="tw-mb-2">
                    <span>Datum vstopa v botrstvo:</span>
                    <div class="tw-font-semibold" dusk="cat-list-item-date-of-arrival-boter">
                        {{ $dateOfArrivalBoter }}
                    </div>
                </div>

                <div class="tw-mb-2">
                    <span>Trenutna starost:</span>
                    <div class="tw-font-semibold" dusk="cat-list-item-current-age">
                        {{ $currentAge }}
                    </div>
                </div>
            @endif
        </div>

        <div class="tw-mt-auto">
            <div class="tw-mb-2">
                <a
                    class="tw-flex tw-items-center tw-font-semibold
                           {{ $cat->is_group ? 'tw-text-white' : 'tw-text-secondary' }}"
                    href="{{ route('cat_details', $cat) }}"
                    dusk="cat-list-item-details-link"
                >
                    <span class="tw-icon">
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
                        class="tw-flex tw-items-center tw-font-semibold tw-text-primary"
                        href="{{ route('become_cat_sponsor', $cat) }}"
                        dusk="cat-list-item-sponsorship-form-link"
                    >
                    <span class="tw-icon">
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
