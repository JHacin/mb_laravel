<article
    class="group flex shadow-lg transition-shadow hover:shadow-xl"
    dusk="cat-list-item-wrapper"
>
    <a
        href="{{ route('cat_details', $cat) }}"
        class="grow max-w-full"
        dusk="cat-list-item"
        data-cat-id="{{ $cat->id }}"
    >
        <x-cat-photo
            src="{{ $cat->first_photo_url }}"
            alt="{{ $cat->name }}"
        ></x-cat-photo>

        <div class="px-5 pt-5 pb-10 space-y-4">
            <div class="space-y-1">
                <h5 class="mb-typography-content-lg mb-font-primary-bold truncate" dusk="cat-list-item-name">
                    {{ $cat->name }}
                </h5>

                <div class="mb-typography-content-sm text-gray-semi">
                    {{ trans_choice('cat.num_sponsors', $cat->sponsorships_count) }}
                </div>
            </div>

            <div class="mb-typography-content-sm mb-font-secondary-regular text-gray-dark">
                {!! $cat->story_short !!}
            </div>

            <div class="mb-link mb-typography-content-sm mb-font-secondary-regular">
                {{ $cat->is_group ? 'Preberi več' : 'Preberi mojo zgodbo' }}
            </div>
        </div>
    </a>
</article>
