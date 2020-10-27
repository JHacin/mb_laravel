@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Muce, ki iščejo botra</h1>

            <div class="columns is-multiline">
                @foreach($cats as $cat)
                    <div class="column is-one-third">
                        <x-cat-list-item :cat="$cat"/>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
