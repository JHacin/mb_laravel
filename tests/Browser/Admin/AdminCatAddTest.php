<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use Carbon\Carbon;
use Facebook\WebDriver\Exception\TimeOutException;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\Pages\AdminCatAddPage;
use Tests\Browser\Admin\Pages\AdminCatListPage;
use Throwable;

class AdminCatAddTest extends AdminTestCase
{
    /**
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->disableHtmlFormValidation($b);
            $this->selectInvalidSelectOption($b, 'status');
            $this->clickSubmitButton($b);
            $this->assertAllRequiredErrorsAreShown($b, ['@name-input-wrapper', '@gender-input-wrapper']);
            $this->assertAdminRadioHasRequiredError($b, 'gender');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_name_field()
    {
        $this->browse(function (Browser $b) {
            $b->loginAs(static::$defaultAdmin);
            $b->visit(new AdminCatAddPage);
            $b->type('name', 'f');
            $this->clickSubmitButton($b);

            $b->assertSee('Ime mora biti dolgo vsaj 2 znaka.');
            $b->type('name', Str::random(101));

            $this->clickSubmitButton($b);
            $b->assertSee('Polje ne sme imeti več kot 100 znakov.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_date_fields_are_in_the_past()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->disableHtmlFormValidation($b);

            $dateInputWrappers = [
                '@date-of-birth-input-wrapper',
                '@date-of-arrival-mh-input-wrapper',
                '@date-of-arrival-boter-input-wrapper',
            ];

            foreach ($dateInputWrappers as $wrapper) {
                $this->selectDatepickerDateInTheFuture($b, $wrapper);
            }

            $this->clickSubmitButton($b);
            $b->assertSee('Datum rojstva mora biti v preteklosti.');
            $b->assertSee('Datum sprejema v zavetišče mora biti v preteklosti.');
            $b->assertSee('Datum vstopa v botrstvo mora biti v preteklosti.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_dates_of_arrival_are_after_or_equal_to_date_of_birth()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            $this->disableHtmlFormValidation($b);
            $this->selectDatepickerDateInThePast($b, '@date-of-birth-input-wrapper', 4);
            $this->selectDatepickerDateInThePast($b, '@date-of-arrival-mh-input-wrapper', 5);
            $this->selectDatepickerDateInThePast($b, '@date-of-arrival-boter-input-wrapper', 5);
            $this->clickSubmitButton($b);
            $b->assertSee('Datum sprejema v zavetišče mora biti kasnejši ali enak datumu rojstva.');
            $b->assertSee('Datum vstopa v botrstvo mora biti kasnejši ali enak datumu rojstva.');

            $b->refresh();
            $this->disableHtmlFormValidation($b);
            $this->selectDatepickerDateInThePast($b, '@date-of-birth-input-wrapper', 4);
            $this->selectDatepickerDateInThePast($b, '@date-of-arrival-mh-input-wrapper', 4);
            $this->selectDatepickerDateInThePast($b, '@date-of-arrival-boter-input-wrapper', 4);
            $b->assertDontSee('Datum sprejema v zavetišče mora biti kasnejši ali enak datumu rojstva.');
            $b->assertDontSee('Datum vstopa v botrstvo mora biti kasnejši ali enak datumu rojstva.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_handles_images_correctly()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            // Cancelling the modal
            $this->attachImage($b);
            $b->with('.modal.show[data-handle="crop-modal"]', function (Browser $browser) {
                $browser->click('.modal-footer button[data-dismiss="modal"]');
            });
            $b->waitUntilMissing('.modal.show[data-handle="crop-modal"]');
            $b->with('@photo-0-input-wrapper', function (Browser $browser) {
                $browser->assertMissing('img.preview-image');
            });

            // Selecting & deleting the image
            $b->refresh();
            $this->attachImage($b);
            $b->with('.modal.show[data-handle="crop-modal"]', function (Browser $b) {
                $b->click('.modal-footer button[data-handle="modalSubmit"]');
            });
            $b->waitUntilMissing('.modal.show[data-handle="crop-modal"]');
            $b->with('@photo-0-input-wrapper', function (Browser $b) {
                $b->assertVisible('img.preview-image');
                $b->click('button.delete-button');
                $b->assertMissing('img.preview-image');
            });

            // Image should be kept after validation errors
            $b->refresh();
            $this->disableHtmlFormValidation($b);
            $this->attachImage($b);
            $b->with('.modal.show[data-handle="crop-modal"]', function (Browser $b) {
                $b->click('.modal-footer button[data-handle="modalSubmit"]');
            });
            $b->pause(1000);
            $this->clickSubmitButton($b);
            $b->with('@photo-0-input-wrapper', function (Browser $b) {
                $b->assertVisible('img.preview-image');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_adding_a_cat_works()
    {
        $this->browse(function (Browser $b) {
            $location = $this->createCatLocation();
            $this->goToPage($b);

            $b->type('name', 'Garfield');

            $this->selectRadioOption($b, '@gender-input-wrapper', Cat::GENDER_MALE);
            $b->select('status', Cat::STATUS_ADOPTED);
            $this->selectRadioOption($b, '@is_group-input-wrapper', 1);

            $dateInputWrappers = [
                '@date-of-birth-input-wrapper',
                '@date-of-arrival-mh-input-wrapper',
                '@date-of-arrival-boter-input-wrapper',
            ];
            foreach ($dateInputWrappers as $wrapper) {
                $this->selectDatepickerDateInThePast($b, $wrapper);
            }

            $dateOfArrivalMhInputValue = $b->value('input[name="date_of_arrival_mh"]');
            $dateOfArrivalBoterInputValue = $b->value('input[name="date_of_arrival_boter"]');

            $b->script("CKEDITOR.instances.story.setData('hello')");

            $b->with('@location-input-wrapper', function (Browser $b) use ($location) {
                $b->click('.select2');
                $b->select('location_id', $location->id);
            });

            $this->clickCheckbox($b, '@is-active-input-wrapper');
            $this->clickSubmitButton($b);
            $b->on(new AdminCatListPage);
            $b->assertSee('Vnos uspešen.');

            $b->with(
                $this->getTableRowSelectorForIndex(1),
                function (Browser $b) use ($location, $dateOfArrivalMhInputValue, $dateOfArrivalBoterInputValue) {
                    $b->assertSee('Garfield');
                    $b->assertSee(Cat::GENDER_LABELS[Cat::GENDER_MALE]);
                    $b->assertSee($this->formatToDateColumnString(Carbon::parse($dateOfArrivalMhInputValue)));
                    $b->assertSee($this->formatToDateColumnString(Carbon::parse($dateOfArrivalBoterInputValue)));
                    $b->assertSee($location->name);
                    $b->assertSee(Cat::STATUS_LABELS[Cat::STATUS_ADOPTED]);
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
            ->attach('input[data-field-name="photo_0"]', __DIR__ . '/../../../database/seeders/assets/fake_cat_photo_0.jpg')
            ->waitFor('.modal.show[data-handle="crop-modal"] .cropper-crop-box');
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminCatListPage)
            ->click('@crud-create-button')
            ->on(new AdminCatAddPage);

        $this->waitForRequestsToFinish($browser);
    }
}
