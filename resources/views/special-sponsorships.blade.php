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

    <div class="mb-container">
        <div class="grid grid-cols-1 xl:grid-cols-2 pt-8">
            <div class="col-span-1 border-x border-b xl:border-r-0 xl:border-b-0 border-gray-light border-dashed">
                <x-special-sponsorships.types-list></x-special-sponsorships.types-list>
            </div>
            <div class="col-span-1 xl:border-l py-8 xl:border-gray-light xl:border-dashed xl:px-8 xl:py-0">
                <x-special-sponsorships.sponsors-of-this-month></x-special-sponsorships.sponsors-of-this-month>
            </div>
        </div>
    </div>
@endsection
