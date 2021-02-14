@php
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

@foreach($socialLinks as $socialLink)
    <span class="icon is-large">
        <a
            href="{{ $socialLink['href'] }}"
            class="nav-social-link {{ $link_class }}"
            dusk="{{ $socialLink['dusk'] }}"
            target="_blank"
        >
            <i class="{{ $socialLink['icon'] }} fa-2x"></i>
        </a>
    </span>
@endforeach
