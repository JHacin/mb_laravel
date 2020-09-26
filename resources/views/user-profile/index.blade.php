@extends('layouts.app')

@section('meta_title', 'Profil | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Moj profil</h1>
            <div>{{ Auth::user()->name }}</div>
        </div>
    </section>
@endsection
