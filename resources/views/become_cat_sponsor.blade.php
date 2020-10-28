@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Dogovor o posvojitvi na daljavo</h1>

            <form method="POST" action="{{ route('become_cat_sponsor', $cat) }}">
                @csrf

                <div class="field">
                    <label for="first_name" class="label is-sr-only">Ime*</label>
                    <div class="control">
                        <input id="first_name" name="first_name" type="text" class="input" placeholder="Ime*" required>
                    </div>
                </div>

                <div class="field">
                    <label for="last_name" class="label is-sr-only">Priimek*</label>
                    <div class="control">
                        <input id="last_name" name="last_name" type="text" class="input" placeholder="Priimek*"
                               required>
                    </div>
                </div>

                <div class="field">
                    <label for="address" class="label is-sr-only">Ulica in hišna številka*</label>
                    <div class="control">
                        <input id="address" name="address" type="text" class="input"
                               placeholder="Ulica in hišna številka*" required>
                    </div>
                </div>

                <div class="field">
                    <label for="zip_code" class="label is-sr-only">Poštna št.*</label>
                    <div class="control">
                        <input id="zip_code" name="zip_code" type="text" class="input" placeholder="Poštna št.*"
                               required>
                    </div>
                </div>

                <div class="field">
                    <label for="city" class="label is-sr-only">Kraj*</label>
                    <div class="control">
                        <input id="city" name="city" type="text" class="input" placeholder="Kraj*" required>
                    </div>
                </div>

                <div class="field">
                    <label for="date_of_birth" class="label is-sr-only">Datum rojstva</label>
                    <div class="control">
                        <input id="date_of_birth" name="date_of_birth" type="text" class="input"
                               placeholder="Datum rojstva">
                    </div>
                </div>

                <div class="field">
                    <label for="phone" class="label is-sr-only">Telefon</label>
                    <div class="control">
                        <input id="phone" name="phone" type="text" class="input" placeholder="Telefon">
                    </div>
                </div>

                <div class="field">
                    <label for="email" class="label is-sr-only">E-mail*</label>
                    <div class="control">
                        <input id="email" name="email" type="email" class="input" placeholder="E-mail*" required>
                    </div>
                    <p class="help">Vpišite vaš pravi e-mail naslov, saj vas le tako lahko obveščamo.</p>
                </div>

                <div class="field">
                    <label for="amount" class="label is-sr-only">Znesek v €*</label>
                    <div class="control">
                        <input id="amount" name="amount" type="text" class="input" placeholder="Znesek v €*" required>
                    </div>
                    <p class="help">Vpišite znesek v €, ki ga želite mesečno nakazovati za vašega posvojenca.</p>
                </div>

                <div class="field">
                    <div class="control">
                        <label class="checkbox" for="is_anonymous">
                            <input type="checkbox" id="is_anonymous" name="is_anonymous">
                            Botrovanje naj bo <strong>anonimno</strong>
                        </label>
                    </div>
                    <p class="help">Označite, če ne želite, da se vaše ime in kraj prikažeta na seznamu botrov
                        meseca.</p>
                </div>

                <div class="content">
                    <p>
                        <span>Ime živali, ki jo želite posvojiti na daljavo:</span>
                        <strong>{{ $cat->name }}</strong>
                        <span>({{ $cat->id }})</span>
                    </p>

                    <p>
                        Po oddaji obrazca boste na svoj mail prejeli samodejni odgovor s podatki za nakazilo.
                        Prosimo, preverite tudi nezaželeno pošto in kategorijo Promocije. V primeru, da sporočila ne
                        prejmete, nam pišite na boter@macjahisa.si.
                    </p>
                </div>

                <div class="field">
                    <div class="control">
                        <label class="checkbox" for="is_agreed_to_terms">
                            <input type="checkbox" id="is_agreed_to_terms" name="is_agreed_to_terms">
                            Potrjujem, da sem seznanjen/a s pravili posvojitve na daljavo in se z njimi strinjam ter
                            Mačji hiši dovoljujem rabo osebnih podatkov izključno za namene obveščanja.
                        </label>
                    </div>
                </div>

                <div class="field">
                    <button type="submit" class="button is-primary">
                        Pošlji obrazec
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('footer-scripts')
    <script src="{{ mix('js/become-cat-sponsor-form.js') }}"></script>
@endsection
