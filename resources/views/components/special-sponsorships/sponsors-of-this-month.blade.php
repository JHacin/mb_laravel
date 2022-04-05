<div class="bg-gray-extralight border border-gray-light border-dashed py-7 px-6 space-y-5">
    <h4 class="text-2xl font-bold text-primary">{{ $title }}</h4>

    @if (count($sponsorshipsPerType) === 0)
        <div>V tem mescu še nismo imeli novih botrov.</div>
    @else
        <div class="space-y-4">
            @foreach ($sponsorshipsPerType as $type => $sponsorships)
                <div>
                    <h5 class="font-semibold">
                        {{ \App\Models\SpecialSponsorship::TYPE_LABELS[$type] }}
                    </h5>

                    <div class="text-sm">
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
    @endif

    {{-- <div>
        <a
            href="{{ route('special_sponsorships_archive') }}"
            class="mb-link"
        >
            Arhiv botrov
        </a>
    </div> --}}
</div>
