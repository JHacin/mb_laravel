<div class="bg-gray-extralight border border-gray-extralight shadow-lg p-6 space-y-6">
    <h4 class="mb-typography-content-lg mb-font-primary-bold text-primary mb-4">{{ $title }}</h4>

    @if (count($sponsorshipsPerType) === 0)
        <div class="mb-typography-content-base">V tem mescu še nismo imeli novih botrov.</div>
    @else
        <div class="mb-typography-content-base space-y-4">
            @foreach ($sponsorshipsPerType as $type => $sponsorships)
                <div>
                    <h5 class="mb-font-primary-semibold">
                        {{ \App\Models\SpecialSponsorship::TYPE_LABELS[$type] }}
                    </h5>

                    <div class="mb-typography-content-sm">
                        @foreach ($sponsorships['identified'] as $sponsor)
                            <x-sponsor-details :sponsor="$sponsor" />
                        @endforeach
                        @if (count($sponsorships['anonymous']) > 0)
                            <div>{{ $sponsorships['anonymous_count_label'] }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mb-typography-content-base"><strong>Hvala vsem!</strong></div>
    @endif

    <div>
        <a
            href="{{ route('special_sponsorships_archive') }}"
            class="mb-link"
        >
            Arhiv botrov
        </a>
    </div>
</div>
