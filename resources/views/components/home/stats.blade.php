@php
    use App\Models\Cat;

    $stats = [
        [
            'value' => '3800+',
            'text' => '<span class="font-extrabold">muc je našlo dom</span> s pomočjo Mačje hiše od nastanka leta 2009',
        ],
        [
            'value' => Cat::count(),
            'text' => '<span class="font-extrabold">muc se je vključilo v botrstvo</span> od začetka projekta marca 2013',
        ],
        [
            'value' => 8,
            'text' => 'mesecev je <span class="font-extrabold">povprečna doba</span> vključenosti muce v botrstvo',
        ],
        [
            'value' => '300+',
            'text' => '<span class="font-extrabold">različnih botrov</span> nam je od začetka projekta pomagalo skrbeti za muce',
        ],
    ]
@endphp

<div class="grid grid-cols-1 border-t border-gray-light border-dotted mb-12 md:grid-cols-4">
    @foreach($stats as $stat)
        <div
            class="
                border-b border-gray-light border-dotted py-6 space-y-2 md:border-r md:last:border-r-0 md:px-6 md:first:pl-0 md:last:pr-0
                lg:space-y-4 lg:py-8 xl:space-y-6 xl:py-10 xl:px-8 2xl:py-12
            "
        >
            <div class="mb-typography-title-2 mb-font-primary-bold text-primary">
                {!! $stat['value'] !!}
            </div>
            <div class="mb-typography-content-base">
                {!! $stat['text'] !!}
            </div>
        </div>
    @endforeach
</div>
