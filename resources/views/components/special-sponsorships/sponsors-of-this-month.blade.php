<div class="has-background-white-ter px-5 py-4">
    <h4 class="title is-4">{{ $title }}</h4>

    <div class="mb-6">
        @if(count($sponsorshipsPerType) === 0)
            <div>V tem mescu še nismo imeli novih botrov.</div>
        @else
            <div class="mb-5">
                @foreach($sponsorshipsPerType as $type => $sponsorships)
                    <div class="{{ !$loop->last ? 'mb-4' : '' }}">
                        <h5 class="has-text-primary has-text-weight-semibold">
                            {{ \App\Models\SpecialSponsorship::TYPE_LABELS[$type] }}
                        </h5>

                        @foreach($sponsorships['identified'] as $sponsor)
                            <x-sponsor-details :sponsor="$sponsor" />
                        @endforeach
                        @if(count($sponsorships['anonymous']) > 0)
                            <div>{{ $sponsorships['anonymous_count_label'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div><strong>Hvala vsem!</strong></div>
        @endif
    </div>

    <div>
        <a href="{{ route('special_sponsorships_archive') }}">
            Arhiv botrov
        </a>
    </div>
</div>
