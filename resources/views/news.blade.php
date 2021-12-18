@extends('layouts.app')

@section('content')
    <section class="tw-section">
        <div class="tw-container tw-mx-auto tw-max-w-screen-xl">
            <div class="tw-mb-6">
                <h1 class="tw-title">Novice</h1>

                <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-y-12 tw-gap-x-8">
                    <div class="tw-col-span-1 lg:tw-col-span-2">
                        <div class="tw-mb-5">
                            @foreach($news as $newsPiece)
                                <div class="tw-mb-5">
                                    <div class="tw-font-semibold tw-mb-1">{{ $newsPiece->title }}</div>
                                    <div class="tw-text-secondary tw-font-semibold tw-mb-1">
                                        {{ $newsPiece->created_at->format(config('date.format.default')) }}
                                    </div>
                                    <div>{{ $newsPiece->body }}</div>
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                        <div>{{ $news->links() }}</div>
                    </div>
                    <div class="tw-col-span-1 lg:tw-col-span-1">
                        <div class="tw-text-center tw-mb-6">
                            <x-fb-feed />
                        </div>
                        <div class="tw-text-center">
                            IG feed
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
