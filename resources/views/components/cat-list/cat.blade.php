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
        <figure class="relative pt-[100%]">
            <img
                class="absolute inset-0"
                src="{{ $cat->first_photo_url }}"
                alt="{{ $cat->name }}"
            >
        </figure>

        <div class="px-5 pt-5 pb-10 space-y-4">
            <div class="space-y-1">
                <h5 class="font-extrabold text-2xl truncate" dusk="cat-list-item-name">
                    {{ $cat->name }}
                </h5>

                <div class="text-gray-500">
                    {{ trans_choice('cat.num_sponsors', $cat->sponsorships_count) }}
                </div>
            </div>



            <div class="font-mono tracking-tight">
                Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
            </div>

            <div class="text-primary font-mono tracking-tight underline underline-offset-4 transition-all">
                {{ $cat->is_group ? 'Preberi več' : 'Preberi mojo zgodbo' }}
            </div>
        </div>
    </a>
</article>
