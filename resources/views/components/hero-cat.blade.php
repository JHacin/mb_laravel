<a
    href="{{ route('cat_details', $cat) }}"
    class="flex flex-col rounded overflow-hidden shadow hover:shadow-lg transition-all"
>
    <img src="{{ $photo_url }}" alt="{{ $cat->name }}" class="flex-1 w-full">

    <div class="flex items-center bg-primary/90 space-x-4 py-3 px-4">
        <div class="text-[#edc0ad] text-2xl">
            <x-icon icon="paw"></x-icon>
        </div>
        <div class="text-white grow overflow-hidden">
            <div class="mb-typography-content-lg mb-font-primary-semibold truncate">
                {{ $cat->name }}
            </div>
            <div class="mb-typography-content-sm font-light truncate">
                {{ $duration_of_stay }} v Mačji hiši
            </div>
        </div>
    </div>
</a>
