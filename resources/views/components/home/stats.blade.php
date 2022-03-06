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

<div class="grid grid-cols-1 border-t border-gray-light border-dotted md:grid-cols-4">
    @foreach ($stats as $stat)
        <div
            class="border-b border-gray-light border-dotted py-6 space-y-2 md:px-6 md:border-r md:last:border-r-0 md:first:pl-0 md:last:pr-0">
            <div class="text-2xl font-extrabold text-primary">
                {{ $stat['value'] }}
            </div>
            <div>
                {{ $stat['text'] }}
            </div>
        </div>
    @endforeach
</div>
