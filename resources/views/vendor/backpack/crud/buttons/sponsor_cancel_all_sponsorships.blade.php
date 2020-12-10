@if ($crud->hasAccess('update') && $entry->sponsorships()->count() > 0)
    <form
        class="d-inline"
        action="{{ route('admin.sponsor_cancel_all_sponsorships', $entry) }}"
        method="POST"
        dusk="sponsor-cancel-all-sponsorships-form"
    >
        @csrf
        <button type="submit" class="btn btn-sm btn-link" dusk="sponsor-cancel-all-sponsorships-form-button">
            <i class="la la-times"></i>
            Prekini vsa botrovanja
        </button>
    </form>

    <script>
        if (typeof handleCancelAllSponsorships !== 'function') {
            function handleCancelAllSponsorships() {
                $('form[dusk="sponsor-cancel-all-sponsorships-form"]').on('submit', function (event) {
                    event.preventDefault();
                    const form = $(this)[0];

                    swal({
                        title: "{!! trans('backpack::base.warning') !!}",
                        text: 'Ali res želite prekiniti vsa aktivna botrovanja, povezana s to osebo?',
                        icon: 'warning',
                        buttons: {
                            cancel: {
                                text: "{!! trans('backpack::crud.cancel') !!}",
                                value: null,
                                visible: true,
                                className: "bg-secondary",
                                closeModal: true,
                            },
                            delete: {
                                text: "{!! trans('forms.confirm') !!}",
                                value: true,
                                visible: true,
                                className: 'bg-danger',
                            }
                        },
                    }).then(function(value) {
                        if (value) {
                            form.submit();
                        }
                    })
                });
            }

            handleCancelAllSponsorships();
        }
    </script>
@endif
