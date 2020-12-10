<?php

namespace Tests\Browser;

use App\Models\Sponsorship;
use Carbon\Carbon;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\AdminTestCase;
use Tests\Browser\Pages\Admin\AdminSponsorshipEditPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipListPage;
use Throwable;

class AdminSponsorshipEditTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_sponsorship_details()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = $this->createSponsorship();
            $this->goToPage($browser, $sponsorship);

            $browser
                ->assertAttribute('select[name="cat"', 'data-current-value', $sponsorship->cat_id)
                ->assertAttribute('select[name="personData"', 'data-current-value', $sponsorship->person_data_id)
                ->assertValue('input[name="monthly_amount"]', $sponsorship->monthly_amount)
                ->assertValue('input[name="is_anonymous"]', (int)$sponsorship->is_anonymous)
                ->assertValue('input[name="is_active"]', (int)$sponsorship->is_active)
                ->assertValue(
                    'input[name="ended_at"]',
                    $sponsorship->ended_at ? $sponsorship->ended_at->toDateString() : ''
                );
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_ended_at_is_not_in_the_future()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = $this->createSponsorship();
            $this->goToPage($browser, $sponsorship);
            $this->selectDatepickerDateInTheFuture($browser, '@ended_at-wrapper');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Datum konca ne sme biti v prihodnosti.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_setting_ended_at_date_works()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = $this->createSponsorship();
            $this->goToPage($browser, $sponsorship);
            $this->selectDatepickerDateInThePast($browser, '@ended_at-wrapper');
            $endedAtValue = $browser->value('input[name="ended_at"]');

            $this->clickSubmitButton($browser);
            $browser->on(new AdminSponsorshipListPage);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable(
                '@data-table-row-details-modal',
                function (Browser $browser) use ($endedAtValue) {
                    $this->assertDetailsModalColumnShowsValue(
                        $browser,
                        7,
                        $this->formatToDateColumnString(Carbon::parse($endedAtValue))
                    );
                }
            );
        });
    }

    /**
     * @param Browser $browser
     * @param Sponsorship $sponsorship
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser, Sponsorship $sponsorship)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminSponsorshipListPage)
            ->visit(new AdminSponsorshipEditPage($sponsorship));

        $this->waitForRequestsToFinish($browser);
    }
}
