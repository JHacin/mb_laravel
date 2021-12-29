<div
    class="shadow-xl border-2 rounded-xl
           grow is-flex flex flex-col overflow-hidden
           {{ $cat->is_group ? 'text-white' : 'text-black' }}
           {{ $cat->is_group ? 'border-primary' : 'border-secondary' }}
           {{ $cat->is_group ? 'bg-primary' : 'bg-secondary' }}"
    dusk="cat-list-item"
    data-cat-id="{{ $cat->id }}"
>
    <div
      class="border-b-2 block relative
             {{ $cat->is_group ? 'border-primary' : 'border-secondary' }}"
    >
        <figure class="block relative pt-[100%]">
            <img
              class="block max-w-full absolute top-0 left-0 right-0 bottom-0 h-full w-full"
              src="{{ $cat->first_photo_url }}"
              alt="{{ $cat->name }}"
            >
        </figure>
    </div>

    <div class="p-6 grow flex flex-col {{ $cat->is_group ? 'bg-primary' : 'bg-white' }}">
        <h5
          class="font-bold text-xl mb-3 {{ $cat->is_group ? 'text-white' : 'text-secondary' }}"
          dusk="cat-list-item-name"
        >{{ $cat->name }}</h5>

        <div class="mb-4">
            <div class="mb-2">
                <span>Trenutno botrov:</span>
                    <span class="font-semibold" dusk="cat-list-item-sponsorship-count">
                    {{ $cat->sponsorships_count }}
                </span>
            </div>

            @if(!$cat->is_group)
                <div class="mb-2">
                    <span>Datum vstopa v botrstvo:</span>
                    <div class="font-semibold" dusk="cat-list-item-date-of-arrival-boter">
                        {{ $dateOfArrivalBoter }}
                    </div>
                </div>

                <div class="mb-2">
                    <span>Trenutna starost:</span>
                    <div class="font-semibold" dusk="cat-list-item-current-age">
                        {{ $currentAge }}
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-auto">
            <div class="mb-2">
                <a
                    class="flex items-center font-semibold
                           {{ $cat->is_group ? 'text-white' : 'text-secondary' }}"
                    href="{{ route('cat_details', $cat) }}"
                    dusk="cat-list-item-details-link"
                >
                    <span class="icon">
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
                        class="flex items-center font-semibold text-primary"
                        href="{{ route('become_cat_sponsor', $cat) }}"
                        dusk="cat-list-item-sponsorship-form-link"
                    >
                    <span class="icon">
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
