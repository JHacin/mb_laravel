@props(['cat'])

@if(count($cat->available_photos) === 0)
  <x-cat-photo
    src="{{ \App\Services\CatPhotoService::getPlaceholderImage() }}"
    alt="{{ $cat->name }}"
  ></x-cat-photo>
@else
  <div class="js-cat-photo-gallery grid grid-cols-3 gap-2 md:gap-3 2xl:gap-4">
    @foreach($cat->available_photos as $photo)
      <div @class([
        'cursor-pointer',
        'col-span-3' => $loop->first,
        'opacity-60 transition-opacity hover:opacity-100' => !$loop->first,
      ])>
        <x-cat-photo
          src="{{ $photo->url }}"
          alt="{{ $cat->name }}"
          data-src="{{ $photo->url }}"
          class="js-gallery-image"
        ></x-cat-photo>
      </div>
    @endforeach
  </div>
@endif

@push('footer-scripts')
  <script src="{{ mix('js/cat-details-gallery.js') }}"></script>
@endpush
