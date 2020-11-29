<?php

namespace Tests\Browser\Admin;

use Carbon\Carbon;
use Facebook\WebDriver\Exception\TimeOutException;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatAddPage;
use Tests\Browser\Pages\Admin\AdminCatListPage;
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
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->click('@crud-form-submit-button');
            $this->assertAllRequiredErrorsAreShown($browser, ['@name-input-wrapper']);
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
            $this->goToPage($browser);

            $this->disableHtmlFormValidation($browser);

            $dateInputWrappers = [
                '@date-of-birth-input-wrapper',
                '@date-of-arrival-mh-input-wrapper',
                '@date-of-arrival-boter-input-wrapper',
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
            $this->goToPage($browser);

            // Cancelling the modal
            $this->attachImage($browser);
            $browser->with('.modal.show[data-handle="crop-modal"]', function (Browser $browser) {
                $browser->click('.modal-footer button[data-dismiss="modal"]');
            });
            $browser->waitUntilMissing('.modal.show[data-handle="crop-modal"]');
            $browser->with('@photo-0-input-wrapper', function (Browser $browser) {
                $browser->assertMissing('img.preview-image');
            });

            // Selecting & deleting the image
            $browser->refresh();
            $this->attachImage($browser);
            $browser->with('.modal.show[data-handle="crop-modal"]', function (Browser $browser) {
                $browser->click('.modal-footer button[data-handle="modalSubmit"]');
            });
            $browser->waitUntilMissing('.modal.show[data-handle="crop-modal"]');
            $browser->with('@photo-0-input-wrapper', function (Browser $browser) {
                $browser
                    ->assertVisible('img.preview-image')
                    ->click('button.delete-button')
                    ->assertMissing('img.preview-image');
            });

            // Image should be kept after validation errors
            $browser->refresh();
            $this->disableHtmlFormValidation($browser);
            $this->attachImage($browser);
            $browser->with('.modal.show[data-handle="crop-modal"]', function (Browser $browser) {
                $browser->click('.modal-footer button[data-handle="modalSubmit"]');
            });
            $browser->pause(1000);
            $browser->click('@crud-form-submit-button');
            $browser->with('@photo-0-input-wrapper', function (Browser $browser) {
                $browser->assertVisible('img.preview-image');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_adding_a_cat_works()
    {
        $this->browse(function (Browser $browser) {
            $location = $this->createCatLocation();

            $this->goToPage($browser);

            $browser->type('name', 'Garfield');

            $browser->with('@gender-input-wrapper', function (Browser $browser) {
                $browser->click('input[value="1"]');
            });

            $dateInputWrappers = [
                '@date-of-birth-input-wrapper',
                '@date-of-arrival-mh-input-wrapper',
                '@date-of-arrival-boter-input-wrapper',
            ];
            foreach ($dateInputWrappers as $wrapper) {
                $browser->with($wrapper, function (Browser $browser) {
                    $browser->click('input[type="text"]');
                });

                $browser->with('.datepicker', function (Browser $browser) {
                    $browser
                        ->click('.datepicker-days thead th.prev')
                        ->click('.datepicker-days thead th.prev')
                        ->click('.datepicker-days tbody > tr > td');
                });
            }

            $dateOfArrivalMhInputValue = $browser->value('input[name="date_of_arrival_mh"]');
            $dateOfArrivalBoterInputValue = $browser->value('input[name="date_of_arrival_boter"]');

            $browser->script("CKEDITOR.instances.story.setData('hello')");

            $browser->with('@location-input-wrapper', function (Browser $browser) use ($location) {
                $browser
                    ->click('.select2')
                    ->select('location_id', $location->id);
            });

            $browser->with('@is-active-input-wrapper', function (Browser $browser) use ($location) {
                $browser->click('input[data-init-function="bpFieldInitCheckbox"]');
            });

            $browser
                ->click('@crud-form-submit-button')
                ->on(new AdminCatListPage);

            $this->waitForRequestsToFinish($browser);

            $browser->assertSee('Vnos uspešen.');

            $browser->with(
                $this->getTableRowSelectorForIndex(1),
                function (Browser $browser) use ($location, $dateOfArrivalMhInputValue, $dateOfArrivalBoterInputValue) {
                    $browser
                        ->assertSee('Garfield')
                        ->assertSee('samec')
                        ->assertSee($this->formatToDateColumnString(Carbon::parse($dateOfArrivalMhInputValue)))
                        ->assertSee($this->formatToDateColumnString(Carbon::parse($dateOfArrivalBoterInputValue)))
                        ->assertSee($location->name)
                        ->assertSee('Da');
                }
            );
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

    protected function goToPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminCatListPage)
            ->click('@crud-create-button')
            ->on(new AdminCatAddPage);
    }
}
