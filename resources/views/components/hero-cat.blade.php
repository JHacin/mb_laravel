<div class="flex md:last:hidden xl:last:block">
    <a href="{{ route('cat_details', $cat) }}" class="flex grow">
        <div class="relative flex shadow grow transition-opacity hover:opacity-90">
            <img src="{{ $photo_url }}" alt="{{ $cat->name }}" class="flex-1 w-full">

            <div class="absolute bottom-6 left-6 md:left-12 right-6 md:right-12 flex
            items-center flex-col md:flex-row text-white py-3 px-4
            rounded-xl shadow bg-primary/90">
                <div class="text-2xl md:text-4xl md:mr-5 text-[#edc0ad]">
                    <i class="fas fa-paw"></i>
                </div>
                <div>
                    <div class="text-center md:text-left text-xl md:text-2xl font-bold">
                        {{ $cat->name }}
                    </div>
                    <div class="text-center md:text-left text-sm md:text-base">
                        {{ $duration_of_stay }} v Mačji hiši
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
