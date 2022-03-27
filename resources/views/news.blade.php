@extends('layouts.app')

@section('content')
    <div class="mb-container">

        <div class="mb-content-offset-l-10">
            <h1 class="mb-page-title mb-6">novice</h1>
            <h2 class="mb-page-subtitle">
                Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Sed porttitor lectus nibh. Cras
                ultricies ligula sed magna dictum porta.
            </h2>
        </div>

        <div class="mb-divider mt-9 mb-7"></div>

        <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
            @foreach ($news as $newsPiece)
                <x-news-piece
                    date="{{ $newsPiece->created_at->format(config('date.format.default')) }} "
                    title="{{ $newsPiece->title }} "
                    body="{{ $newsPiece->body }}"
                ></x-news-piece>
            @endforeach
        </div>

        <div>{{ $news->onEachSide(1)->links() }}</div>
    </div>
@endsection
