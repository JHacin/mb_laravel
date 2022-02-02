@extends('layouts.app')

@section('content')
  <div class="mb-page-content-container">

    <div class="mb-page-header-container">
      <h1 class="mb-page-title">novice</h1>
      <h2 class="mb-page-subtitle">
        Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Sed porttitor lectus nibh. Cras
        ultricies ligula sed magna dictum porta.
      </h2>
    </div>

    <div class="mb-divider"></div>

    <div class="mb-content-block grid grid-cols-1 gap-6 lg:grid-cols-2">
      @foreach($news as $newsPiece)
        <x-news-piece
          date="{{ $newsPiece->created_at->format(config('date.format.default'))}} "
          title="{{ $newsPiece->title}} "
          body="{{ $newsPiece->body }}"
        ></x-news-piece>
      @endforeach
    </div>

    <div>{{ $news->onEachSide(1)->links() }}</div>
  </div>
@endsection
