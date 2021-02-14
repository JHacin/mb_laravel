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
     * @return void
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->disableHtmlFormValidation($b);
            $this->clickSubmitButton($b);
            $this->assertAllRequiredErrorsAreShown($b, ['@name-input-wrapper']);
            $this->assertAdminRadioHasRequiredError($b, 'gender');
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
                ->type('name', 'f');
            $this->clickSubmitButton($browser);

            $browser
                ->assertSee('Ime mora biti dolgo vsaj 2 znaka.')
                ->type('name', Str::random(101));

            $this->clickSubmitButton($browser);
            $browser->assertSee('Polje ne sme imeti več kot 100 znakov.');
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
                $this->selectDatepickerDateInTheFuture($browser, $wrapper);
            }

            $this->clickSubmitButton($browser);
            $browser
                ->assertSee('Datum rojstva mora biti v preteklosti.')
                ->assertSee('Datum sprejema v zavetišče mora biti v preteklosti.')
                ->assertSee('Datum vstopa v botrstvo mora biti v preteklosti.');
        });
    }

    /**
     * @return void
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
            $this->clickSubmitButton($browser);
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

            $this->selectRadioOption($browser, '@gender-input-wrapper', Cat::GENDER_MALE);
            $this->selectRadioOption($browser, '@is_group-input-wrapper', 1);

            $dateInputWrappers = [
                '@date-of-birth-input-wrapper',
                '@date-of-arrival-mh-input-wrapper',
                '@date-of-arrival-boter-input-wrapper',
            ];
            foreach ($dateInputWrappers as $wrapper) {
                $this->selectDatepickerDateInThePast($browser, $wrapper);
            }

            $dateOfArrivalMhInputValue = $browser->value('input[name="date_of_arrival_mh"]');
            $dateOfArrivalBoterInputValue = $browser->value('input[name="date_of_arrival_boter"]');

            $browser->script("CKEDITOR.instances.story.setData('hello')");

            $browser->with('@location-input-wrapper', function (Browser $browser) use ($location) {
                $browser
                    ->click('.select2')
                    ->select('location_id', $location->id);
            });

            $this->clickCheckbox($browser, '@is-active-input-wrapper');
            $this->clickSubmitButton($browser);
            $browser->on(new AdminCatListPage);
            $browser->assertSee('Vnos uspešen.');

            $browser->with(
                $this->getTableRowSelectorForIndex(1),
                function (Browser $browser) use ($location, $dateOfArrivalMhInputValue, $dateOfArrivalBoterInputValue) {
                    $browser
                        ->assertSee('Garfield')
                        ->assertSee(Cat::GENDER_LABELS[Cat::GENDER_MALE])
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
