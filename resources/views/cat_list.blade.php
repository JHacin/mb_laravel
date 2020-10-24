@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Muce, ki iščejo botra</h1>

            <div class="columns is-multiline">
                @foreach($cats as $cat)
                    <div class="column is-one-third">
                        <div class="card">
                            <div class="card-image">
                                <figure class="image is-1by1">
                                    <img src="{{ $cat->first_photo_url }}" alt="{{ $cat->name }}">
                                </figure>
                            </div>

                            <div class="card-content">
                                <div class="media">
                                    <div class="media-content">
                                        <p class="title is-4">{{ $cat->name }}</p>
                                        <p class="subtitle is-6">{{ $cat->getGenderLabel() }}</p>
                                    </div>
                                </div>

                                <div class="content">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Phasellus nec iaculis mauris.
                                </div>
                            </div>

                            <footer class="card-footer">
                                <a href="#" class="card-footer-item">Preberi mojo zgodbo</a>
                                <a href="#" class="card-footer-item">Postani moj boter</a>
                            </footer>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
