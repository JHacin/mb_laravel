@php
use App\Models\Cat;

$stats = [
    [
        'value' => '3800+',
        'text' => 'muc je našlo dom s pomočjo Mačje hiše od nastanka leta 2009',
    ],
    [
        'value' => Cat::count(),
        'text' => 'muc se je vključilo v botrstvo od začetka projekta marca 2013',
    ],
    [
        'value' => 8,
        'text' => 'mesecev je povprečna doba vključenosti muce v botrstvo',
    ],
    [
        'value' => '300+',
        'text' => 'različnih botrov nam je od začetka projekta pomagalo skrbeti za muce',
    ],
];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-4">
    @foreach ($stats as $stat)
        <div
            class="mb-section space-y-2 border-x border-b last:border-b-0 border-gray-light border-dashed lg:border-r-0 lg:border-b-0 lg:last:border-r lg:space-y-5">
            <div
                class="text-4xl font-bold text-primary px-4 relative before:bg-primary before:block before:absolute before:left-0 before:-translate-x-1/2 before:w-[2px] before:h-full lg:px-5 lg:text-5xl">
                {{ $stat['value'] }}
            </div>
            <div class="px-4 text-lg md:px-5">
                {{ $stat['text'] }}
            </div>
        </div>
    @endforeach
</div>
