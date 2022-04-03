@extends('layouts.app')

@section('content')
    <div class="mb-page-header">
        <div class="mb-container grid grid-cols-5">
            <div class="col-span-full lg:col-span-3">
                <h1 class="mb-page-title mb-6">Novice</h1>
                <h2 class="mb-page-subtitle">
                    Na tem mestu so zbrane novice glede naših oskrbovancev. Če želite biti v rednem stiku z vsem, kar se nam
                    dogaja, nam lahko
                    tudi sledite na družbenih omrežjih <a
                        href="{{ config('links.facebook_page') }}"
                        class="mb-link"
                    >Facebook</a> in <a
                        href="{{ config('links.instagram_page') }}"
                        class="mb-link"
                    >Instagram</a>.
                </h2>
            </div>
        </div>
    </div>

    <div class="mb-container mb-section">
        <div class="mb-7 grid grid-cols-1 gap-6 lg:grid-cols-2">
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
