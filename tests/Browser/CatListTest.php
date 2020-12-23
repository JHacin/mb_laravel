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
                'date_of_birth' => Carbon::now()->subYear()->subMonth()->subDays(4)
            ]);
        }
    }


    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_cat_details()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            $b->with($this->getSampleCatCardSelector(), function (Browser $b) {
               $b->assertSeeIn('@cat-list-item-name', 'Lojza');
               $this->assertEquals(
                   static::$sampleCat->sponsorships()->count(),
                   $b->text('@cat-list-item-sponsorship-count'),

               );
               $b->assertSeeIn('@cat-list-item-date-of-arrival-boter', '21. 8. 1999');
               $b->assertSeeIn('@cat-list-item-current-age', '1 leto in 1 mesec');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_doesnt_count_inactive_sponsorships()
    {
        $this->browse(function (Browser $b) {
            Sponsorship::factory()->createOne([
                'is_active' => false,
                'cat_id' => static::$sampleCat->id,
            ]);

            $this->goToPage($b);
            $b->with($this->getSampleCatCardSelector(), function (Browser $b) {
                $this->assertEquals(
                    static::$sampleCat->sponsorships()->count(),
                    $b->text('@cat-list-item-sponsorship-count'),
                );
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_links_work()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->with($this->getSampleCatCardSelector(), function (Browser $b) {
                $b->click('@cat-list-item-details-link');
                $b->on(new CatDetailsPage(static::$sampleCat));
            });

            $this->goToPage($b);
            $b->with($this->getSampleCatCardSelector(), function (Browser $b) {
                $b->click('@cat-list-item-sponsorship-form-link');
                $b->on(new CatSponsorshipFormPage(static::$sampleCat));
            });
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
    public function test_clicking_per_page_links_works()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->assertCount(15, $b->elements('@cat-list-item'));
            $b->assertQueryStringMissing('per_page');
            $b->click('@per_page_30');
            $this->assertCount(30, $b->elements('@cat-list-item'));
            $b->assertQueryStringHas('per_page', 30);
            $b->click('@per_page_15');
            $this->assertCount(15, $b->elements('@cat-list-item'));
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
            $this->assertHasClass($b, '@per_page_15', 'has-text-weight-semibold');

            $b->click('@per_page_30');
            $this->assertNotHasClass($b, '@per_page_15', 'has-text-weight-semibold');
            $this->assertHasClass($b, '@per_page_30', 'has-text-weight-semibold');
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
     * @return void
     * @throws Throwable
     */
    public function test_sponsorship_count_sort_links_work()
    {
        $this->browse(function (Browser $b) {
            $this->createCatWithSponsorships([], 0);
            $this->createCatWithSponsorships([], 99);
            $this->goToPage($b);

            $b->assertQueryStringMissing('sponsorship_count');
            $b->click('@sponsorship_count_sort_asc');
            $b->assertQueryStringHas('sponsorship_count', 'asc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) {
                $this->assertEquals(0, $b->text('@cat-list-item-sponsorship-count'));
            });

            $b->click('@sponsorship_count_sort_desc');
            $b->assertQueryStringHas('sponsorship_count', 'desc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) {
                $this->assertEquals(99, $b->text('@cat-list-item-sponsorship-count'));
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_date_of_birth_sort_links_work()
    {
        $this->browse(function (Browser $b) {
            $oldest = $this->createCat(['date_of_birth' => Carbon::now()->subYears(300)]);
            $youngest = $this->createCat(['date_of_birth' => Carbon::now()]);
            $this->goToPage($b);

            $b->assertQueryStringMissing('age');
            $b->click('@age_sort_asc');
            $b->assertQueryStringHas('age', 'asc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) use ($youngest) {
                $this->assertEquals($youngest->name, $b->text('@cat-list-item-name'));
            });

            $b->click('@age_sort_desc');
            $b->assertQueryStringHas('age', 'desc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) use ($oldest) {
                $this->assertEquals($oldest->name, $b->text('@cat-list-item-name'));
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_id_sort_links_work()
    {
        $this->browse(function (Browser $b) {
            /** @var Cat $first */
            $first = Cat::orderBy('id')->first();
            /** @var Cat $latest */
            $latest = Cat::orderBy('id', 'desc')->first();
            $this->goToPage($b);

            $b->assertQueryStringMissing('id');
            $b->click('@id_sort_asc');
            $b->assertQueryStringHas('id', 'asc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) use ($first) {
                $this->assertEquals($first->name, $b->text('@cat-list-item-name'));
            });

            $b->click('@id_sort_desc');
            $b->assertQueryStringHas('id', 'desc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) use ($latest) {
                $this->assertEquals($latest->name, $b->text('@cat-list-item-name'));
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_highlights_id_desc_sort_link_by_default()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->assertNotHasClass($b, '@id_sort_desc', 'has-text-grey-darker');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_highlights_active_sort_links()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            $this->assertHasClass($b, '@sponsorship_count_sort_asc', 'has-text-grey-darker');
            $this->assertHasClass($b, '@sponsorship_count_sort_desc', 'has-text-grey-darker');

            $b->click('@sponsorship_count_sort_asc');
            $this->assertNotHasClass($b, '@sponsorship_count_sort_asc', 'has-text-grey-darker');
            $this->assertHasClass($b, '@sponsorship_count_sort_desc', 'has-text-grey-darker');

            $b->click('@sponsorship_count_sort_desc');
            $this->assertHasClass($b, '@sponsorship_count_sort_asc', 'has-text-grey-darker');
            $this->assertNotHasClass($b, '@sponsorship_count_sort_desc', 'has-text-grey-darker');

            $b->click('@age_sort_asc');
            $this->assertNotHasClass($b, '@age_sort_asc', 'has-text-grey-darker');
            $this->assertHasClass($b, '@age_sort_desc', 'has-text-grey-darker');

            $b->click('@age_sort_desc');
            $this->assertHasClass($b, '@age_sort_asc', 'has-text-grey-darker');
            $this->assertNotHasClass($b, '@age_sort_desc', 'has-text-grey-darker');

            $b->click('@id_sort_asc');
            $this->assertNotHasClass($b, '@id_sort_asc', 'has-text-grey-darker');
            $this->assertHasClass($b, '@id_sort_desc', 'has-text-grey-darker');

            $b->click('@id_sort_desc');
            $this->assertHasClass($b, '@id_sort_asc', 'has-text-grey-darker');
            $this->assertNotHasClass($b, '@id_sort_desc', 'has-text-grey-darker');
        });
    }

    /**
     * @return string
     */
    protected function getSampleCatCardSelector(): string
    {
        return '[dusk="cat-list-item"][data-cat-id="' . static::$sampleCat->id . '"]';
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
