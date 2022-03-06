<a
    href="{{ route('cat_details', $cat) }}"
    class="flex flex-col rounded overflow-hidden shadow hover:shadow-lg transition-all"
>
    <img
        src="{{ $photo_url }}"
        alt="{{ $cat->name }}"
        class="flex-1 w-full"
    >

    <div class="flex items-center bg-primary/90 space-x-4 py-3 px-4">
        <x-icon
            icon="paw"
            class="text-[#edc0ad] text-xl"
        ></x-icon>
        <div class="text-white grow overflow-hidden">
            <div class="text-base font-bold truncate">
                {{ $cat->name }}
            </div>
            <div class="text-sm font-light truncate">
                {{ $duration_of_stay }} v Mačji hiši
            </div>
        </div>
    </div>
</a>
