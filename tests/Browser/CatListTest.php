<?php

namespace Tests\Browser;

use App\Models\Cat;
use App\Models\Sponsorship;
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
            static::$sampleCat = $this->createCatWithSponsorships([
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
            $this->assertCatDetailsElementHasData($browser, 'sponsorship-count', '6');
            $this->assertCatDetailsElementHasData($browser, 'date-of-arrival-boter', '21. 8. 1999');
            $this->assertCatDetailsElementHasData($browser, 'current-age', '1 leto in 1 mesec');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_doesnt_count_inactive_sponsorships()
    {
        $this->browse(function (Browser $browser) {
            Sponsorship::factory()->createOne([
                'is_active' => false,
                'cat_id' => static::$sampleCat->id,
            ]);

            $this->goToPage($browser);
            $this->assertCatDetailsElementHasData($browser, 'sponsorship-count', '6');
        });
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
     * @return void
     * @throws Throwable
     */
    public function test_shows_first_15_cats_by_default()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->assertCount(15, $b->elements('@cat-list-item'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_pagination_page_links_work()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            // Page 1 link is active by default, back button is disabled
            $b->assertAriaAttribute('@pagination-link-page-1', 'current', 'page');
            $b->assertAriaAttribute('@pagination-previous', 'disabled', 'true');

            // Clicking other links works
            $b->click('@pagination-link-page-2');
            $b->assertQueryStringHas('page', 2);
            $b->assertAriaAttribute('@pagination-link-page-2', 'current', 'page');

            // Prev/Next buttons work
            $b->click('@pagination-previous');
            $b->assertQueryStringHas('page', 1);
            $b->assertAriaAttribute('@pagination-link-page-1', 'current', 'page');

            $b->click('@pagination-next');
            $b->assertQueryStringHas('page', 2);
            $b->assertAriaAttribute('@pagination-link-page-2', 'current', 'page');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_per_page_options()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            $perPageOptions = [15, 30, Cat::count()];

            foreach ($perPageOptions as $option) {
                $selector = '@per_page_' . $option;
                $b->assertVisible($selector);
                $b->assertAttribute($selector, 'href', route('cat_list', ['per_page' => $option]));
            }
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_clicking_per_page_link_sets_query_parameter()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->assertQueryStringMissing('per_page');
            $b->click('@per_page_30');
            $b->assertQueryStringHas('per_page', 30);
            $b->click('@per_page_15');
            $b->assertQueryStringHas('per_page', 15);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_active_per_page_link_is_highlighted()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->assertStringContainsString('has-text-weight-semibold', $b->attribute('@per_page_15', 'class'));

            $b->click('@per_page_30');
            $this->assertStringNotContainsString('has-text-weight-semibold', $b->attribute('@per_page_15', 'class'));
            $this->assertStringContainsString('has-text-weight-semibold', $b->attribute('@per_page_30', 'class'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_clicking_per_page_link_resets_to_page_1()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->click('@pagination-link-page-2');
            $b->assertQueryStringHas('page', 2);
            $b->click('@per_page_30');
            $b->assertQueryStringHas('per_page', 30);
            $b->assertQueryStringMissing('page');
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
