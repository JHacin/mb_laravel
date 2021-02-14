<div class="home-header">
    <div class="columns is-gapless is-align-items-flex-end mb-0">
        <div class="column"></div>
        <div class="column has-text-centered">
            <img src="{{ asset('/img/logo_with_text.png') }}" alt="Mačji boter" class="home-header__logo">
        </div>
        <div class="home-header__social column has-text-centered">
            @include('components.layout.navbar-social-links', ['link_class' => 'nav-social-link--home-header'])
        </div>
    </div>
</div>
