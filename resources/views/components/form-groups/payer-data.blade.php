<div class="columns is-multiline">
    <div class="column is-4">
        <x-inputs.base.input
            name="personData[first_name]"
            label="{{ trans('person_data.first_name') }}"
            required
        />
    </div>
    <div class="column is-5">
        <x-inputs.base.input
            name="personData[last_name]"
            label="{{ trans('person_data.last_name') }}"
            required
        />
    </div>
    <div class="column is-3">
        <x-inputs.person-gender
            name="personData[gender]"
            label="{{ trans('person_data.gender') }}"
            wrapperClass="is-fullwidth"
        />
    </div>
    <div class="column is-8">
        <x-inputs.base.input
            name="personData[address]"
            label="{{ trans('person_data.address') }}"
            required
        />
    </div>
    <div class="column is-4">
        <x-inputs.base.input
            name="personData[zip_code]"
            label="{{ trans('person_data.zip_code') }}"
            required
        />
    </div>
    <div class="column is-6">
        <x-inputs.base.input
            name="personData[city]"
            label="{{ trans('person_data.city') }}"
            required
        />
    </div>
    <div class="column is-6">
        <x-inputs.country
            name="personData[country]"
            label="{{ trans('person_data.country') }}"
            required
            wrapperClass="is-fullwidth"
        />
    </div>
    <div class="column is-12">
        <x-inputs.email
            name="personData[email]"
            label="{{ trans('user.email') }}"
            required
        >
            <x-slot name="help">
                Vpišite vaš pravi e-mail naslov, saj vas le tako lahko obveščamo.
            </x-slot>
        </x-inputs.email>
    </div>
</div>
