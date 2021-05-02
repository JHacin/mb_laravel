@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <div class="mb-6">
                <h1 class="title">Novice</h1>

                <div class="columns">
                    <div class="column is-9-desktop">
                        <div class="mb-5">
                            @foreach($news as $newsPiece)
                                <div class="news-piece mb-5">
                                    <div class="news-piece__title">{{ $newsPiece->title }}</div>
                                    <div class="news-piece__created">
                                        {{ $newsPiece->created_at->format(config('date.format.default')) }}
                                    </div>
                                    <div>{{ $newsPiece->body }}</div>
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                        <div>{{ $news->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
