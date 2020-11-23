<?php

namespace Tests\Browser\Admin;

use Facebook\WebDriver\Exception\TimeOutException;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatAddPage;
use Throwable;

class AdminCatAddTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(static::$defaultAdmin)
                ->visit(new AdminCatAddPage);

            $this->disableHtmlFormValidation($browser);
            $browser->click('@crud-form-submit-button');
            $this->assertAllRequiredErrorsAreShown($browser, ['@add-cat-form-name-input-wrapper']);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_name_field()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(static::$defaultAdmin)
                ->visit(new AdminCatAddPage)
                ->type('input[name="date_of_arrival_mh"]', '2022')
                ->type('name', 'f')
                ->click('@crud-form-submit-button')
                ->assertSee('Ime mora biti dolgo vsaj 2 znaka.')
                ->type('name', Str::random(101))
                ->click('@crud-form-submit-button')
                ->assertSee('Polje ne sme imeti več kot 100 znakov.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_date_fields_are_in_the_past()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(static::$defaultAdmin)
                ->visit(new AdminCatAddPage);

            $this->disableHtmlFormValidation($browser);

            $dateInputWrappers = [
                '@add-cat-form-date-of-birth-input-wrapper',
                '@add-cat-form-date-of-arrival-mh-input-wrapper',
                '@add-cat-form-date-of-arrival-boter-input-wrapper',
            ];

            foreach ($dateInputWrappers as $wrapper) {
                $browser->with($wrapper, function (Browser $browser) {
                    $browser->click('input[type="text"]');
                });

                $browser->with('.datepicker', function (Browser $browser) {
                    $browser
                        ->click('.datepicker-days thead th.next')
                        ->click('.datepicker-days thead th.next')
                        ->click('.datepicker-days tbody > tr > td');
                });
            }

            $browser
                ->click('@crud-form-submit-button')
                ->assertSee('Datum rojstva mora biti v preteklosti.')
                ->assertSee('Datum sprejema v zavetišče mora biti v preteklosti.')
                ->assertSee('Datum vstopa v botrstvo mora biti v preteklosti.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_handles_images_correctly()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(static::$defaultAdmin)
                ->visit(new AdminCatAddPage);

            $this->assertCancelingImageModalWorks($browser);
            $this->assertSelectingAndDeletingImageWorks($browser);
            $this->assertSelectedImageIsKeptAfterValidation($browser);
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeOutException
     */
    protected function assertCancelingImageModalWorks(Browser $browser)
    {
        $this->attachImage($browser);
        $browser->with('.modal.show[data-handle="crop-modal"]', function (Browser $browser) {
            $browser->click('.modal-footer button[data-dismiss="modal"]');
        });
        $browser->waitUntilMissing('.modal.show[data-handle="crop-modal"]');
        $browser->with('@add-cat-form-photo-0-input-wrapper', function (Browser $browser) {
            $browser->assertMissing('img.preview-image');
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeOutException
     */
    protected function assertSelectingAndDeletingImageWorks(Browser $browser)
    {
        $browser->refresh();
        $this->attachImage($browser);
        $browser->with('.modal.show[data-handle="crop-modal"]', function (Browser $browser) {
            $browser->click('.modal-footer button[data-handle="modalSubmit"]');
        });
        $browser->waitUntilMissing('.modal.show[data-handle="crop-modal"]');
        $browser->with('@add-cat-form-photo-0-input-wrapper', function (Browser $browser) {
            $browser
                ->assertVisible('img.preview-image')
                ->click('button.delete-button')
                ->assertMissing('img.preview-image');
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeOutException
     */
    protected function assertSelectedImageIsKeptAfterValidation(Browser $browser)
    {
        $browser->refresh();
        $this->disableHtmlFormValidation($browser);
        $this->attachImage($browser);
        $browser->with('.modal.show[data-handle="crop-modal"]', function (Browser $browser) {
            $browser->click('.modal-footer button[data-handle="modalSubmit"]');
        });
        $browser->pause(1000);
        $browser->click('@crud-form-submit-button');
        $browser->with('@add-cat-form-photo-0-input-wrapper', function (Browser $browser) {
            $browser->assertVisible('img.preview-image');
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeOutException
     */
    protected function attachImage(Browser $browser)
    {
        $browser
            ->attach('input[data-field-name="photo_0"]', __DIR__ . '/../../../resources/img/logo.png')
            ->waitFor('.modal.show[data-handle="crop-modal"] .cropper-crop-box');
    }
}
