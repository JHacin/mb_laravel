@extends('layouts.app')

@section('content')
    <div class="mb-container">
        <div class="mb-content-offset-l-9 mb-content-offset-r-11">
            <h1 class="mb-page-title mb-6">posebna botrstva</h1>
            <h2 class="mb-page-subtitle">
                Pri oskrbi muc nam lahko pomagate tudi brez, da bi se pri tem zavezali k vsakomesečnim donacijam za
                določeno muco ali skupino muc. Posebna botrstva so enkratne donacije, ki nam jih lahko namenite
                takrat, ko to želite oz. zmorete. Pri tem vam ponujamo več možnosti, od splošne donacije do bolj
                usmerjenih, s katerimi pomagate pri oskrbi muc, ki to najbolj potrebujejo.
            </h2>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-4 mt-section">
            <div class="col-span-1 xl:col-span-6">
                <x-special-sponsorships.types-list></x-special-sponsorships.types-list>
            </div>
            <div class="col-span-1 xl:col-span-5 xl:col-start-8">
                <x-special-sponsorships.sponsors-of-this-month></x-special-sponsorships.sponsors-of-this-month>
            </div>
        </div>
    </div>
@endsection
