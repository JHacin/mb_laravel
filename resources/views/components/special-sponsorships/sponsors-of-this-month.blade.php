<div class="has-background-white-ter px-5 py-4">
    <h4 class="title is-4">{{ $title }}</h4>

    @if(count($sponsorsPerType) === 0)
        <div>V tem mescu še nismo imeli novih botrov.</div>
    @else
        <div class="mb-5">
            @foreach($sponsorsPerType as $type => $sponsors)
                <div class="{{ !$loop->last ? 'mb-4' : '' }}">
                    <h5 class="has-text-primary has-text-weight-semibold">
                        {{ \App\Models\SpecialSponsorship::TYPE_LABELS[$type] }}
                    </h5>

                    @foreach($sponsors as $sponsor)
                        <x-sponsor-details :sponsor="$sponsor"/>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div><strong>Hvala vsem!</strong></div>
    @endif
</div>
