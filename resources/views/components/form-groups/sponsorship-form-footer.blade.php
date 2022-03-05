<div class="block">
    <x-inputs.base.checkbox name="is_anonymous">
        <x-slot name="label">
            Botrstvo naj bo <strong>anonimno</strong>
        </x-slot>
        <x-slot name="help">
            Označite, če ne želite, da se vaše ime in kraj prikažeta na seznamu botrov.
        </x-slot>
    </x-inputs.base.checkbox>
</div>

<div class="block">
    Po oddaji obrazca boste na svoj mail prejeli samodejni odgovor s podatki za nakazilo.
    Prosimo, preverite tudi nezaželeno pošto in kategorijo Promocije. V primeru, da sporočila ne
    prejmete, nam pišite na boter@macjahisa.si.
</div>

<div class="block">
    <x-inputs.base.checkbox
        name="is_agreed_to_terms"
        required
    >
        <x-slot name="label">
            Potrjujem, da sem seznanjen/a s pravili posvojitve na daljavo in se z njimi strinjam ter
            Mačji hiši dovoljujem rabo osebnih podatkov izključno za namene obveščanja.
        </x-slot>
    </x-inputs.base.checkbox>
</div>

<div class="field">
    <button
        type="submit"
        class="button is-primary is-medium"
        dusk="cat-sponsorship-submit"
    >
        Pošlji obrazec
    </button>
</div>

<button
    class="mb-btn mb-btn-secondary"
    type="submit"
    dusk="cat-sponsorship-submit"
>
    pošlji obrazec
</button>
