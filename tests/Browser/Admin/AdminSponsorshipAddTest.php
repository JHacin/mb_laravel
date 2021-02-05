<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorshipAddPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipListPage;
use Throwable;

class AdminSponsorshipAddTest extends AdminTestCase
{
    /**
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->disableHtmlFormValidation($b);
            $this->clickSubmitButton($b);
            $this->assertAllRequiredErrorsAreShown($b, ['@cat-wrapper', '@personData-wrapper']);
            $monthlyAmountWithError = $b->element('div[dusk="monthly_amount-wrapper"].text-danger');
            $this->assertNotNull($monthlyAmountWithError);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_monthly_amount()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);

            $this->disableHtmlFormValidation($browser);
            $browser->type('monthly_amount', '4.99');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Minimalni mesečni znesek je 5€.');

            $this->disableHtmlFormValidation($browser);
            $browser->type('monthly_amount', '1000000');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Vrednost ne sme biti večja od 999999.99.');

            $this->disableHtmlFormValidation($browser);
            $browser->script("document.querySelector('input[name=\"monthly_amount\"]').setAttribute('type', 'text')");
            $browser->type('monthly_amount', '4f');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Vrednost mora biti številka');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_selects_have_the_right_options()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->assertSelectHasOptions('cat', Cat::pluck('id')->toArray());
            $b->assertSelectHasOptions('personData', PersonData::pluck('id')->toArray());
        });
    }

    /**
     * @throws Throwable
     */
    public function test_adding_works()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            /** @var Cat $cat */
            $cat = Cat::inRandomOrder()->first();
            /** @var PersonData $personData */
            $personData = PersonData::inRandomOrder()->first();


            $b->select('cat', $cat->id);
            $b->select('personData', $personData->id);
            $b->type('monthly_amount', '25.44');
            $this->selectRadioOption($b, '@payment_type-input-wrapper', Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT);
            $this->clickCheckbox($b, '@is_anonymous-wrapper');

            $this->clickSubmitButton($b);

            $b->on(new AdminSponsorshipListPage);
            $b->assertSee('Vnos uspešen.');

            $this->assertDatabaseHas('sponsorships', [
                'cat_id' => $cat->id,
                'person_data_id' => $personData->id,
                'is_anonymous' => 1,
                'payment_type' => Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT,
                'monthly_amount' => 25.44,
                'is_active' => 0,
            ]);

            $this->openFirstRowDetails($b);
            $b->whenAvailable(
                '@data-table-row-details-modal',
                function (Browser $b) use ($cat, $personData) {
                    $this->assertDetailsModalShowsValuesInOrder($b, [
                        1 => $cat->name_and_id,
                        2 => $personData->email_and_id,
                        3 => number_format('25.44', 2, ',', '.') . ' €',
                        4 => 'Da',
                        5 => 'Ne',
                    ]);
                }
            );
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_cat_doesnt_already_an_active_sponsorship_with_the_selected_sponsor()
    {
        $this->browse(function (Browser $b) {
            $sponsorship = $this->createSponsorship([
                'cat_id' => $this->createCat()->id,
                'person_data_id' => $this->createPersonData()->id,
                'is_active' => true,
            ]);

            $this->goToPage($b);

            $b->select('cat', $sponsorship->cat_id);
            $b->select('personData', $sponsorship->person_data_id);
            $b->type('monthly_amount', '10');

            $this->clickSubmitButton($b);
            $b->assertSee('Muca že ima aktivnega botra s tem email naslovom.');

            $sponsorship->update(['is_active' => false]);
            $this->clickSubmitButton($b);
            $b->assertSee('Vnos uspešen.');
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminSponsorshipListPage)
            ->click('@crud-create-button')
            ->on(new AdminSponsorshipAddPage);

        $this->waitForRequestsToFinish($browser);
    }
}
