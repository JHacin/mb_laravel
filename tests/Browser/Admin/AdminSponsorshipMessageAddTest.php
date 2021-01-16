<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\SponsorshipMessageType;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageAddPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageListPage;
use Throwable;

class AdminSponsorshipMessageAddTest extends AdminTestCase
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
            $this->assertAllRequiredErrorsAreShown($b, ['@cat-wrapper', '@personData-wrapper', '@messageType-wrapper']);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_selects_have_the_right_options()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->assertSelectHasOptions('messageType', SponsorshipMessageType::pluck('id')->toArray());
            $b->assertSelectHasOptions('personData', PersonData::pluck('id')->toArray());
            $b->assertSelectHasOptions('cat', Cat::pluck('id')->toArray());
        });
    }

    /**
     * @throws Throwable
     */
    public function test_adding_works()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            /** @var SponsorshipMessageType $messageType */
            $messageType = SponsorshipMessageType::inRandomOrder()->first();
            /** @var PersonData $personData */
            $personData = PersonData::inRandomOrder()->first();
            /** @var Cat $cat */
            $cat = Cat::inRandomOrder()->first();

            $b->select('messageType', $messageType->id);
            $b->select('personData', $personData->id);
            $b->select('cat', $cat->id);

            $this->clickSubmitButton($b);
            $b->on(new AdminSponsorshipMessageListPage);
            $b->assertSee('Vnos uspešen.');

            $this->openFirstRowDetails($b);

            $b->whenAvailable(
                '@data-table-row-details-modal',
                function (Browser $b) use ($messageType, $cat, $personData) {
                    $this->assertDetailsModalShowsValuesInOrder($b, [
                        1 => $messageType->name,
                        2 => $personData->email_and_user_id,
                        3 => $cat->name_and_id,
                    ]);
                }
            );
        });
    }

    /**
     * @param Browser $b
     * @throws TimeoutException
     */
    protected function goToPage(Browser $b)
    {
        $b->loginAs(static::$defaultAdmin);
        $b->visit(new AdminSponsorshipMessageListPage);
        $b->click('@crud-create-button');
        $b->on(new AdminSponsorshipMessageAddPage);

        $this->waitForRequestsToFinish($b);
    }
}
