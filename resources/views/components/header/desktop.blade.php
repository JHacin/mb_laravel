@props(['pageLinks'])

@php
$currentRouteName = Route::currentRouteName();
$isHomepage = $currentRouteName === 'home';
@endphp

<header @class([
    'flex items-center pt-3 lg:pt-6',
    'bg-gray-extralight' => $isHomepage,
])>
    <div class="mb-container flex-grow">
        <nav
            role="navigation"
            aria-label="glavni meni"
            class="flex justify-between space-x-4"
        >
            <div class="flex items-center justify-between">
                <span
                    class="xl:hidden flex items-center cursor-pointer p-2 mr-2 text-2xl md:text-4xl md:mr-4"
                    role="button"
                    data-mobile-nav-open-btn
                >
                    <x-icon icon="burger"></x-icon>
                </span>

                <a
                    href="{{ route('home') }}"
                    dusk="navbar-home-link"
                >
                    <img
                        src="{{ mix('img/logo.svg') }}"
                        alt="Mačji boter"
                        class="h-[60px] md:h-[90px] lg:h-[105px] xl:h-[130px] 2xl:h-[160px]"
                    />
                </a>
            </div>

            <div class="flex items-center">
                <div class="hidden xl:flex items-center space-x-6 mr-7">
                    @foreach ($pageLinks as $pageLink)
                        <a
                            class="text-lg font-semibold transition-all hover:text-gray-semi"
                            href="{{ route($pageLink['route_name']) }}"
                            dusk="{{ $pageLink['dusk'] }}"
                        >
                            {{ $pageLink['label'] }}
                        </a>
                    @endforeach
                </div>

                <a
                    class="mb-btn mb-btn-primary text-lg justify-self-end"
                    href="{{ route('become_sponsor_overview') }}"
                >
                    <span>postani boter</span>
                </a>
            </div>
        </nav>

        @if ($isHomepage)
            <section class="grid grid-cols-4 py-8 lg:py-9">
                <div class="col-span-full lg:col-span-3 space-y-6">
                    <h1 class="mb-page-title">
                        Mačji boter je projekt Mačje hiše, ki omogoča
                        <span class="text-secondary">posvojitve muck na daljavo</span>.
                    </h1>
                    <div class="mb-page-subtitle">
                        Namenjen je vsem tistim, ki nam želite pomagati pri oskrbi nekoč brezdomnih muck. Gre za obliko
                        donacije, ki donatorja poveže z določenim mucem ali skupino mucov in mu hkrati omogoča boljši
                        vpogled v to, za kaj je bil porabljen njegov prispevek.
                    </div>
                    <div>
                        <a
                            class="mb-btn mb-btn-outline text-lg"
                            href="{{ route('become_sponsor_overview') }}"
                        >Postani boter</a>
                    </div>
                </div>
            </section>
        @endif
    </div>
</header>
