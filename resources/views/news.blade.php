@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container mx-auto max-w-screen-xl">
            <div class="mb-6">
                <x-page-title text="Novice"></x-page-title>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-12 gap-x-8">
                    <div class="col-span-1 lg:col-span-2">
                        <div class="mb-5">
                            @foreach($news as $newsPiece)
                                <div class="mb-5">
                                    <div class="font-semibold mb-1">{{ $newsPiece->title }}</div>
                                    <div class="text-secondary font-semibold mb-1">
                                        {{ $newsPiece->created_at->format(config('date.format.default')) }}
                                    </div>
                                    <div>{{ $newsPiece->body }}</div>
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                        <div>{{ $news->links() }}</div>
                    </div>
                    <div class="col-span-1 lg:col-span-1">
                        <div class="text-center mb-6">
                            <x-fb-feed />
                        </div>
                        <div class="text-center">
                            IG feed
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
