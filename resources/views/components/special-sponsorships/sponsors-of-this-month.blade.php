<div class="has-background-white-ter px-5 py-4">
    <h4 class="title is-4">{{ $title }}</h4>

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
