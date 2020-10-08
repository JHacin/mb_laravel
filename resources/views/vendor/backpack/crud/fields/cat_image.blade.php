@php
$value = old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ))
@endphp

@include('crud::fields.inc.wrapper_start')
<div class="wrapper" data-init-function="bpFieldInitImageAjax" data-state="">
    <div>
        <label>{!! $field['label'] !!}</label>
    </div>

    <div data-handle="previewArea" class="image-preview-container mb-2">
        <img src="" alt="">
    </div>

    <div class="btn-group align-items-center">
        <div class="btn btn-light btn-sm btn-file">
            {{ trans('backpack::crud.choose_file') }}
            <input
                type="file"
                accept="image/*"
                data-handle="uploadImage"
                @include('crud::fields.inc.attributes')
            >
            <input
                type="hidden"
                data-handle="hiddenImage"
                name="{{ $field['name'] }}"
                value="{{ $value }}"
            >
        </div>
        <button class="delete-button btn btn-light btn-sm" type="button" data-handle="remove">
            <i class="la la-trash text-danger"></i>
        </button>
        <div class="loading-spinner spinner-border spinner-border-sm text-secondary ml-1" role="status">
            <span class="sr-only">Nalagam...</span>
        </div>
    </div>

    <div data-handle="modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Priprava slike</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        Sliko obreži na želeno velikost, nato klikni na gumb <strong>Potrdi</strong>.
                        Zaradi konsistentnosti morajo vse slike imeti enako razmerje dimenzij.
                    </div>
                    <div>
                        <img data-handle="mainImage" src="" alt="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Prekliči</button>
                    <button type="button" class="btn btn-primary" data-handle="modalSubmit">Potrdi</button>
                </div>
            </div>
        </div>
    </div>
</div>
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    @push('crud_fields_styles')
        <link href="{{ asset('packages/cropperjs/dist/cropper.min.css') }}" rel="stylesheet" type="text/css" />
        <style>
            .image-preview-container {
                width: 200px;
                max-width: 100%;
            }

            .image-preview-container img {
                width: 100%;
            }

            .loading-spinner {
               display: none;
            }

            .wrapper[data-state="loading"] .loading-spinner {
                display: block;
            }

            img {
                max-width: 100%;
            }

            .btn-file {
                position: relative;
                overflow: hidden;
            }

            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }
        </style>
    @endpush

    @push('crud_fields_scripts')
        <script src="{{ asset('packages/cropperjs/dist/cropper.min.js') }}"></script>
        <script src="{{ asset('packages/jquery-cropper/dist/jquery-cropper.min.js') }}"></script>

        <script>
            function bpFieldInitImageAjax($element) {
                const $mainImage = $element.find('[data-handle=mainImage]');
                const $uploadImage = $element.find("[data-handle=uploadImage]");
                const $hiddenImage = $element.find("[data-handle=hiddenImage]");
                const $removeBtn = $element.find("[data-handle=remove]");
                const $previewArea = $element.find("[data-handle=previewArea]");
                const $modal = $element.find("[data-handle=modal]");
                const $modalSubmit = $modal.find('[data-handle=modalSubmit]');

                // https://github.com/fengyuanchen/cropperjs#options
                const cropperOptions = {
                    viewMode: 1,
                    aspectRatio: 1,
                }

                if (!$hiddenImage.val()){
                    $previewArea.hide();
                    $removeBtn.hide();
                }

                $mainImage.attr('src', $hiddenImage.val());

                $uploadImage.on('change', function(event) {
                    $modal.appendTo('body').modal('show');

                    $modal.on('shown.bs.modal', function() {
                        const file = event.target.files[0];
                        const fr = new FileReader();
                        fr.readAsDataURL(file);

                        fr.onload = function() {
                            $uploadImage.val('');

                            $mainImage
                                .cropper(cropperOptions)
                                .cropper('reset', true)
                                .cropper('replace', this.result);
                        }
                    })

                    $modalSubmit.on('click', function () {
                        const imageURL = $mainImage.cropper('getCroppedCanvas').toDataURL('image/jpeg');
                        $hiddenImage.val(imageURL);
                        $previewArea.find('img').attr('src', imageURL);

                        const data = new FormData();
                        data.append('photo_base64', $hiddenImage.val());

                        $element.attr('data-state', 'loading');
                        $modal.modal('hide');

                        $.ajax({
                            url: 'http://homestead.test/api/cat-photos/upload',
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            method: 'POST',
                            success: function(data) {
                                $previewArea.show();
                                $hiddenImage.val(data.path);
                                $removeBtn.attr('data-name', data.name);
                                $removeBtn.show();
                            },
                            complete: function () {
                                $element.attr('data-state', '');
                            }
                        });
                    });
                });

                $removeBtn.on('click', function () {
                    const name = $(this).attr('data-name');

                    $element.attr('data-state', 'loading');

                    $.ajax({
                        url: `http://homestead.test/api/cat-photos/${name}/delete`,
                        method: 'POST',
                        success: function() {
                            $mainImage.cropper("destroy");
                            $mainImage.attr('src','');
                            $hiddenImage.val('');
                            $removeBtn.hide();
                            $previewArea.hide();
                        },
                        complete: function () {
                            $element.attr('data-state', '');
                        }
                    });
                });
            }
        </script>
    @endpush
@endif
