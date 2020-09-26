@extends('layouts.app')

@section('meta_title', 'Potrditev email naslova | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Potrditev email naslova</h1>

            @if (session('resent'))
                <div class="notification is-success">
                   Na email naslov smo vam poslali novo povezavo.
                </div>
            @endif

            <div>Pred nadaljevanjem je treba opraviti potrditev email naslova. Na mail vam je bila poslana povezava.</div>
            <div>Če povezave niste prejeli,</div>
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">kliknite tukaj, da vam jo ponovno pošljemo.</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
