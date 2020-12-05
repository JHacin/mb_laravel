<?php

namespace Tests\Browser;

use App\Models\Cat;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatDetailsPage;
use Tests\Browser\Pages\CatListPage;
use Tests\Browser\Pages\CatSponsorshipFormPage;
use Tests\DuskTestCase;
use Throwable;

class CatListTest extends DuskTestCase
{
    /**
     * @var Cat|null
     */
    protected static ?Cat $sampleCat = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$sampleCat) {
            static::$sampleCat = $this->createCat([
                'name' => 'Lojza',
                'date_of_arrival_boter' => '1999-08-21',
                'date_of_birth' => Carbon::now()->subYears(1)->subMonths(1)->subDays(4)
            ]);
        }
    }


    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_cat_details()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->assertCatDetailsElementHasData($browser, 'name', 'Lojza');
            $this->assertCatDetailsElementHasData($browser, 'sponsorship-count', '0');
            $this->assertCatDetailsElementHasData($browser, 'date-of-arrival-boter', '21. 8. 1999');
            $this->assertCatDetailsElementHasData($browser, 'current-age', '1 leto in 1 mesec');
;        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_links_work()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $browser
                ->click($this->getCatDetailsSelector() . '-details-link')
                ->on(new CatDetailsPage(static::$sampleCat));

            $this->goToPage($browser);
            $browser
                ->click($this->getCatDetailsSelector() . '-sponsorship-form-link')
                ->on(new CatSponsorshipFormPage(static::$sampleCat));
        });
    }

    /**
     * @param Browser $browser
     * @param string $element
     * @param string $data
     */
    protected function assertCatDetailsElementHasData(Browser $browser, string $element, string $data)
    {
        $browser->with(
            $this->getCatDetailsSelector() . '-' . $element,
            function (Browser $browser) use ($data) {
                $browser->assertSee($data);
            }
        );
    }

    /**
     * @return string
     */
    protected function getCatDetailsSelector(): string
    {
        return '@cat-list-item-' . static::$sampleCat->id;
    }

    /**
     * @param Browser $browser
     * @return Browser
     */
    protected function goToPage(Browser $browser): Browser
    {
        return $browser->visit(new CatListPage);
    }
}
