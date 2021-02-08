@php
    $currentRouteName = Route::currentRouteName();

    $pageLinks = [
        [
            'label' => 'Postani redni boter',
            'route_name' => 'cat_list',
            'dusk' => 'navbar-cat-list-link',
        ],
        [
            'label' => 'Postani boter meseca',
            'route_name' => 'become_sponsor_of_the_month',
            'dusk' => 'navbar-become-sponsor-of-the-month-link',
        ],
        [
            'label' => 'Podari botrstvo',
            'route_name' => 'gift_sponsorship',
            'dusk' => 'navbar-gift-sponsorship-link',
        ],
        [
            'label' => 'Novice',
            'route_name' => 'news',
            'dusk' => 'navbar-news-link',
        ],
    ];

    $socialLinks = [
        [
            'href' => 'mailto:' . config('links.contact_email'),
            'icon' => 'far fa-envelope',
            'dusk' => 'navbar-contact-email-link',
        ],
        [
            'href' => config('links.instagram_page'),
            'icon' => 'fab fa-instagram',
            'dusk' => 'navbar-instagram-link',
        ],
        [
            'href' => config('links.facebook_page'),
            'icon' => 'fab fa-facebook',
            'dusk' => 'navbar-facebook-link',
        ],
    ]
@endphp


<nav class="navbar is-primary is-fixed-top" role="navigation" aria-label="glavni meni">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('home') }}" dusk="navbar-home-link">
            <img class="nav-logo" src="{{ asset('/img/logo.png') }}" alt="Mačji boter">
        </a>

        <a
            role="button"
            class="navbar-burger burger"
            aria-label="meni"
            aria-expanded="false"
            data-target="navbar"
        >
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbar" class="navbar-menu">
        <div class="navbar-start is-justify-content-center is-flex-grow-1">
            @foreach($pageLinks as $pageLink)
                <a
                    class="navbar-item nav-link{{ $currentRouteName === $pageLink['route_name'] ? ' nav-link--active' : '' }}"
                    href="{{ route($pageLink['route_name']) }}"
                    dusk="{{ $pageLink['dusk'] }}"
                >
                    {{ $pageLink['label'] }}
                </a>
            @endforeach
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                @foreach($socialLinks as $socialLink)
                    <span class="icon is-large">
                        <a
                            href="{{ $socialLink['href'] }}"
                            class="has-text-white"
                            dusk="{{ $socialLink['dusk'] }}"
                            target="_blank"
                        >
                            <i class="{{ $socialLink['icon'] }} fa-2x"></i>
                        </a>
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</nav>

{{--                <div class="navbar-end">--}}
{{--                    <div class="navbar-item has-dropdown is-hoverable" dusk="navbar-profile-section">--}}
{{--                        <a class="navbar-link is-arrowless px-4">--}}
{{--                            <span class="icon is-medium">--}}
{{--                                <i class="fas fa-user is-size-5"></i>--}}
{{--                            </span>--}}
{{--                        </a>--}}

{{--                        <div class="navbar-dropdown is-right">--}}
{{--                            @auth--}}
{{--                                <a--}}
{{--                                    class="navbar-item"--}}
{{--                                    href="{{ route('user-profile') }}"--}}
{{--                                    dusk="nav-profile-button"--}}
{{--                                >--}}
{{--                                    Profil--}}
{{--                                </a>--}}

{{--                                <form id="logout-form" action="{{ route('logout') }}" method="POST">--}}
{{--                                    @csrf--}}
{{--                                    <button type="submit" class="navbar-item button" dusk="nav-logout-button">--}}
{{--                                        Odjava--}}
{{--                                    </button>--}}
{{--                                </form>--}}
{{--                            @endauth--}}

{{--                            @guest--}}
{{--                                <a class="navbar-item" href="{{ route('register') }}" dusk="nav-register-button">--}}
{{--                                    Registracija--}}
{{--                                </a>--}}
{{--                                <a class="navbar-item" href="{{ route('login') }}" dusk="nav-login-button">--}}
{{--                                    Prijava--}}
{{--                                </a>--}}
{{--                            @endguest--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
