@props(['numResults'])

<form
    action="{{ route('cat_list') }}"
    method="GET"
>
    @foreach (['per_page', 'sponsorship_count', 'age', 'id'] as $query)
        @isset($query)
            <input
                type="hidden"
                name="{{ $query }}"
                value="{{ request($query) }}"
            >
        @endisset
    @endforeach
    <x-inputs.base.input
        name="search"
        placeholder="Išči po imenu"
        label="Išči po imenu"
        value="{{ request('search') }}"
    >
        <x-slot name="addon">
            <button
                class="text-gray-semi hover:text-primary transition-all"
                type="submit"
                dusk="search-submit"
            >
                <x-icon icon="search"></x-icon>
            </button>
        </x-slot>
    </x-inputs.base.input>
</form>
