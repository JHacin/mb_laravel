<?php

namespace Tests\Browser;

use App\Models\Cat;
use App\Models\PersonData;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\AdminTestCase;
use Tests\Browser\Pages\Admin\AdminSponsorshipAddPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipListPage;
use Throwable;

class AdminSponsorshipAddTest extends AdminTestCase
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
            $this->waitForRequestsToFinish($browser);
            $this->assertAllRequiredErrorsAreShown($browser, ['@cat-wrapper', '@personData-wrapper']);
            $monthlyAmountWithError = $browser->element('div[dusk="monthly_amount-wrapper"].text-danger');
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
            $browser->click('@crud-form-submit-button');
            $this->waitForRequestsToFinish($browser);
            $browser->assertSee('Minimalni mesečni znesek je 5€.');

            $this->disableHtmlFormValidation($browser);
            $browser->type('monthly_amount', '1000000');
            $browser->click('@crud-form-submit-button');
            $this->waitForRequestsToFinish($browser);
            $browser->assertSee('Vrednost ne sme biti večja od 999999.99.');

            $this->disableHtmlFormValidation($browser);
            $browser->script("document.querySelector('input[name=\"monthly_amount\"]').setAttribute('type', 'text')");
            $browser->type('monthly_amount', '4f');
            $browser->click('@crud-form-submit-button');
            $this->waitForRequestsToFinish($browser);
            $browser->assertSee('Vrednost mora biti številka');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_selects_have_the_right_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $browser->assertSelectHasOptions('cat', Cat::pluck('id')->toArray());
            $browser->assertSelectHasOptions('personData', PersonData::pluck('id')->toArray());
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_adding_works()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);

            /** @var Cat $cat */
            $cat = Cat::inRandomOrder()->first();
            /** @var PersonData $personData */
            $personData = PersonData::inRandomOrder()->first();

            $data = [
                'monthly_amount' => '25.44',
                'is_anonymous' => true,
                'is_active' => true,
            ];

            $browser
                ->select('cat', $cat->id)
                ->select('personData', $personData->id)
                ->type('monthly_amount', $data['monthly_amount'])
                ->with('@is_anonymous-wrapper', function (Browser $browser) {
                    $browser->click('input[data-init-function="bpFieldInitCheckbox"]');
                });

            $browser
                ->click('@crud-form-submit-button')
                ->on(new AdminSponsorshipListPage);

            $this->waitForRequestsToFinish($browser);

            $browser->assertSee('Vnos uspešen.');

            $this->openFirstRowDetails($browser);

            $browser->whenAvailable(
                '@data-table-row-details-modal',
                function (Browser $browser) use ($cat, $personData, $data) {
                    $this->assertDetailsModalShowsValuesInOrder($browser, [
                        1 => $cat->name_and_id,
                        2 => $personData->email_and_user_id,
                        3 => number_format($data['monthly_amount'], 2, ',', '.') . ' €',
                        4 => 'Da',
                        5 => 'Ne',
                    ]);
                }
            );
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
