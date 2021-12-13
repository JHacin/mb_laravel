<div class="tw-flex md:last:tw-hidden xl:last:tw-block">
    <a href="{{ route('cat_details', $cat) }}" class="tw-flex tw-flex-grow">
        <div class="tw-relative tw-flex tw-shadow tw-flex-grow tw-transition-opacity hover:tw-opacity-90">
            <img src="{{ $photo_url }}" alt="{{ $cat->name }}" class="tw-flex-1 tw-w-full">

            <div class="tw-absolute tw-bottom-6 tw-left-6 md:tw-left-12 tw-right-6 md:tw-right-12 tw-flex
            tw-items-center tw-flex-col md:tw-flex-row tw-text-white tw-py-3 tw-px-4
            tw-rounded-xl tw-shadow tw-bg-primary/90">
                <div class="tw-text-2xl md:tw-text-4xl md:tw-mr-5 tw-text-[#edc0ad]">
                    <i class="fas fa-paw"></i>
                </div>
                <div>
                    <div class="tw-text-center md:tw-text-left tw-text-xl md:tw-text-2xl tw-font-bold">
                        {{ $cat->name }}
                    </div>
                    <div class="tw-text-center md:tw-text-left tw-text-sm md:tw-text-base">
                        {{ $duration_of_stay }} v Mačji hiši
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
