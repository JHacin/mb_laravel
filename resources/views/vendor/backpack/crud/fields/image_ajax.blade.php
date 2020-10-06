<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
<input
    type="file"
{{--    name="{{ $field['name'] }}"--}}
    value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
    data-init-function="bpFieldInitImageAjax"
    @include('crud::fields.inc.attributes')
>
<input type="hidden" name="{{ $field['name'] }}">
<button type="button" class="delete-button">Delete</button>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- no styles -->
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>

function bpFieldInitImageAjax($element) {
    const $hiddenInput = $('input[name="{{ $field['name'] }}"]');
    const $deleteBtn = $('.delete-button');

    $element.on('change', function(event) {
        const file = event.target.files[0];
        const data = new FormData();
        data.append('image', file);

        $.ajax({
            url: 'http://homestead.test/api/cat-photos/upload',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(data) {
                $hiddenInput.val(data.path);
                $deleteBtn.attr('data-name', data.name);
            }
        });
    });

    $deleteBtn.on('click', function () {
        const name = $(this).attr('data-name');

        $.ajax({
            url: `http://homestead.test/api/cat-photos/${name}/delete`,
            method: 'POST',
            success: function(data) {
                console.log(data);
            }
        });
    });
}

        </script>
    @endpush
@endif
