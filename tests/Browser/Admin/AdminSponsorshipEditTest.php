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
     * @var Sponsorship|null
     */
    protected static ?Sponsorship $sampleSponsorship = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$sampleSponsorship) {
            static::$sampleSponsorship = Sponsorship::latest('id')->first();
        }
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_sponsorship_details()
    {

        $this->browse(function (Browser $browser) {
            /** @var Sponsorship $sponsorship */
            $sponsorship = static::$sampleSponsorship;
            $this->goToPage($browser);

            $browser
                ->assertAttribute('select[name="cat"', 'data-current-value', $sponsorship->cat_id)
                ->assertAttribute('select[name="personData"', 'data-current-value', $sponsorship->person_data_id)
                ->assertValue('input[name="monthly_amount"]', $sponsorship->monthly_amount)
                ->assertValue('input[name="is_anonymous"]', $sponsorship->is_anonymous)
                ->assertValue('input[name="is_active"]', $sponsorship->is_active)
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
            $this->goToPage($browser);
            $this->selectDatepickerDateInTheFuture($browser, '@ended_at-wrapper');
            $browser->click('@crud-form-submit-button');
            $this->waitForRequestsToFinish($browser);
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
            $this->goToPage($browser);
            $this->selectDatepickerDateInThePast($browser, '@ended_at-wrapper');
            $endedAtValue = $browser->value('input[name="ended_at"]');

            $browser
                ->click('@crud-form-submit-button')
                ->on(new AdminSponsorshipListPage);

            $this->waitForRequestsToFinish($browser);
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
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminSponsorshipListPage)
            ->visit(new AdminSponsorshipEditPage(static::$sampleSponsorship));

        $this->waitForRequestsToFinish($browser);
    }
}
