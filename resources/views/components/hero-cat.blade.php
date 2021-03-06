<div class="hero-cat-column column is-6-tablet is-4-widescreen">
    <a href="{{ route('cat_details', $cat) }}" class="is-flex-grow-1 is-flex">
        <div class="hero-cat">
            <img src="{{ $photo_url }}" alt="{{ $cat->name }}" class="hero-cat__image">

            <div class="hero-cat-label">
                <div class="hero-cat-label__icon">
                    <i class="fas fa-paw"></i>
                </div>
                <div>
                    <div class="hero-cat-label__name">
                        {{ $cat->name }}
                    </div>
                    <div class="hero-cat-label__duration-of-stay">
                        {{ $duration_of_stay }} v Mačji hiši
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
