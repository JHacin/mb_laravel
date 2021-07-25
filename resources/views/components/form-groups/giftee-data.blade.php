@php
    $isGiftRadioOptions = [
        'no' => 'Zame',
        'yes' => 'Darilo',
    ];
@endphp

<x-inputs.base.radio
    name="is_gift"
    :options="$isGiftRadioOptions"
    checked="no"
    label="Botrstvo je:"
    isInline
/>

<div class="giftee-form has-background-white-ter p-5" style="display: none;">
    <h3 class="title is-4 has-text-primary">Podatki obdarovanca</h3>

    <div class="columns is-multiline mb-4">
        <div class="column is-4">
            <x-inputs.base.input
                name="giftee[first_name]"
                label="{{ trans('person_data.first_name') }}"
                required
            />
        </div>
        <div class="column is-5">
            <x-inputs.base.input
                name="giftee[last_name]"
                label="{{ trans('person_data.last_name') }}"
                required
            />
        </div>
        <div class="column is-3">
            <x-inputs.person-gender
                name="giftee[gender]"
                label="{{ trans('person_data.gender') }}"
                wrapperClass="is-fullwidth"
            />
        </div>
        <div class="column is-8">
            <x-inputs.base.input
                name="giftee[address]"
                label="{{ trans('person_data.address') }}"
                required
            />
        </div>
        <div class="column is-4">
            <x-inputs.base.input
                name="giftee[zip_code]"
                label="{{ trans('person_data.zip_code') }}"
                required
            />
        </div>
        <div class="column is-6">
            <x-inputs.base.input
                name="giftee[city]"
                label="{{ trans('person_data.city') }}"
                required
            />
        </div>
        <div class="column is-6">
            <x-inputs.country
                name="giftee[country]"
                label="{{ trans('person_data.country') }}"
                required
                wrapperClass="is-fullwidth"
            />
        </div>
        <div class="column is-12">
            <x-inputs.email
                name="giftee[email]"
                label="{{ trans('user.email') }}"
                required
            />
        </div>
    </div>
</div>


<div class="giftee-form has-background-white-ter p-5" style="display: none;">
    <h3 class="title is-4 has-text-primary">Podatki obdarovanca</h3>

    <div class="columns is-multiline mb-4">
        <div class="column is-4">
            <x-inputs.base.input
                name="giftee[first_name]"
                label="{{ trans('person_data.first_name') }}"
                required
            />
        </div>
        <div class="column is-5">
            <x-inputs.base.input
                name="giftee[last_name]"
                label="{{ trans('person_data.last_name') }}"
                required
            />
        </div>
        <div class="column is-3">
            <x-inputs.person-gender
                name="giftee[gender]"
                label="{{ trans('person_data.gender') }}"
                wrapperClass="is-fullwidth"
            />
        </div>
        <div class="column is-8">
            <x-inputs.base.input
                name="giftee[address]"
                label="{{ trans('person_data.address') }}"
                required
            />
        </div>
        <div class="column is-4">
            <x-inputs.base.input
                name="giftee[zip_code]"
                label="{{ trans('person_data.zip_code') }}"
                required
            />
        </div>
        <div class="column is-6">
            <x-inputs.base.input
                name="giftee[city]"
                label="{{ trans('person_data.city') }}"
                required
            />
        </div>
        <div class="column is-6">
            <x-inputs.country
                name="giftee[country]"
                label="{{ trans('person_data.country') }}"
                required
                wrapperClass="is-fullwidth"
            />
        </div>
        <div class="column is-12">
            <x-inputs.email
                name="giftee[email]"
                label="{{ trans('user.email') }}"
                required
            />
        </div>
    </div>
</div>

@push('footer-scripts')
    <script src="{{ mix('js/giftee_form.js') }}"></script>
@endpush
