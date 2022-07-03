@extends('layouts.app')

@section('content')
    <div class="mb-page-header">
        <div class="mb-container">
            <div class="grid grid-cols-5">
                <div class="col-span-full lg:col-span-3">
                    <h1 class="mb-page-title mb-6">Posebna botrstva</h1>
                    <h2 class="mb-page-subtitle">
                        Pri oskrbi muc nam lahko pomagate tudi brez, da bi se pri tem zavezali k vsakomesečnim donacijam za
                        določeno muco ali skupino muc. Posebna botrstva so enkratne donacije, ki nam jih lahko namenite
                        takrat, ko to želite oz. zmorete. Pri tem vam ponujamo več možnosti, od splošne donacije do bolj
                        usmerjenih, s katerimi pomagate pri oskrbi muc, ki to najbolj potrebujejo.
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-container mb-section">
        <x-special-sponsorships.types-list></x-special-sponsorships.types-list>
    </div>
@endsection
