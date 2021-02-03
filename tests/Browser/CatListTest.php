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
    protected const SORT_FIELDS = ['sponsorship_count', 'age', 'id'];
    protected const SORT_DIRECTIONS = ['asc', 'desc'];
    protected static ?Cat $sampleCat = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$sampleCat) {
            static::$sampleCat = $this->createCatWithSponsorships();
        }
    }


    /**
     * @throws Throwable
     */
    public function test_shows_individual_cat_details_correctly()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat([
                'name' => 'Lojza',
                'date_of_arrival_boter' => '1999-08-21',
                'date_of_birth' => Carbon::now()->subYear()->subMonth()->subDays(4),
                'is_group' => false,
            ]);

            $this->goToPage($b, '?per_page=all');
            $catDetailsCardSelector = $this->getCatByIdCardSelector($cat);
            $this->assertNotHasClass($b, $catDetailsCardSelector, 'cat-list-item--group');

            $b->with($catDetailsCardSelector, function (Browser $b) use ($cat) {
               $b->assertSeeIn('@cat-list-item-name', $cat->name);
               $this->assertEquals($cat->sponsorships()->count(), $b->text('@cat-list-item-sponsorship-count'));
               $b->assertSeeIn('@cat-list-item-date-of-arrival-boter', '21. 8. 1999');
               $b->assertSeeIn('@cat-list-item-current-age', '1 leto in 1 mesec');
               $b->assertSeeIn('@cat-list-item-details-link', 'Preberi mojo zgodbo');
               $b->assertSeeIn('@cat-list-item-sponsorship-form-link', 'Postani moj boter');
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_cat_group_details_correctly()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat([
                'name' => 'Pikiji',
                'is_group' => true,
            ]);

            $this->goToPage($b, '?per_page=all');
            $catDetailsCardSelector = $this->getCatByIdCardSelector($cat);
            $this->assertHasClass($b, $catDetailsCardSelector, 'cat-list-item--group');

            $b->with($catDetailsCardSelector, function (Browser $b) use ($cat) {
               $b->assertSeeIn('@cat-list-item-name', $cat->name);
               $b->assertMissing('@cat-list-item-date-of-arrival-boter');
               $b->assertMissing('@cat-list-item-current-age');
                $b->assertSeeIn('@cat-list-item-details-link', 'Preberi več');
                $b->assertSeeIn('@cat-list-item-sponsorship-form-link', 'Postani boter');
            });
        });
    }

    /**
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
            $b->with($this->getCatByIdCardSelector(static::$sampleCat), function (Browser $b) {
                $this->assertEquals(
                    static::$sampleCat->sponsorships()->count(),
                    $b->text('@cat-list-item-sponsorship-count'),
                );
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_links_work()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->with($this->getCatByIdCardSelector(static::$sampleCat), function (Browser $b) {
                $b->click('@cat-list-item-details-link');
                $b->on(new CatDetailsPage(static::$sampleCat));
            });

            $this->goToPage($b);
            $b->with($this->getCatByIdCardSelector(static::$sampleCat), function (Browser $b) {
                $b->click('@cat-list-item-sponsorship-form-link');
                $b->on(new CatSponsorshipFormPage(static::$sampleCat));
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_first_12_cats_by_default()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->assertCount(Cat::PER_PAGE_DEFAULT, $b->elements('@cat-list-item'));
        });
    }

    /**
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
     * @throws Throwable
     */
    public function test_searching_by_name_works()
    {
        $this->browse(function (Browser $b) {
            $andrejcek = $this->createCat(['name' => 'Andrejček']);
            $miha = $this->createCat(['name' => 'Miha']);
            $this->goToPage($b);
            $this->submitSearch($b, 'drejč');
            $b->assertInputValue('@search-input', 'drejč');
            $b->assertVisible($this->getCatByIdCardSelector($andrejcek));
            $b->assertMissing($this->getCatByIdCardSelector($miha));

            $this->submitSearch($b, 'iha');
            $b->assertMissing($this->getCatByIdCardSelector($andrejcek));
            $b->assertVisible($this->getCatByIdCardSelector($miha));

            $this->submitSearch($b, 'dsfdsfdsfsaxsa');
            $b->assertMissing($this->getCatByIdCardSelector($andrejcek));
            $b->assertMissing($this->getCatByIdCardSelector($miha));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_search_respects_other_active_queries()
    {
        $this->browse(function (Browser $b) {
            $catName = 'test';
            Cat::factory()->count(Cat::PER_PAGE_24 + 1)->create(['name' => $catName]);

            foreach (Cat::PER_PAGE_OPTIONS as $perPage) {
                foreach (static::SORT_FIELDS as $sort) {
                    foreach (static::SORT_DIRECTIONS as $direction) {
                        $b->visitRoute('cat_list', ['per_page' => $perPage, $sort => $direction]);
                        $this->submitSearch($b, $catName);
                        $b->assertQueryStringHas('per_page', $perPage);
                        $b->assertQueryStringHas($sort, $direction);
                        $b->assertQueryStringHas('search', $catName);
                    }
                }
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function test_clearing_search_works()
    {
        $this->browse(function (Browser $b) {
            $latestCat = $this->createCat();
            $this->goToPage($b);
            $b->assertQueryStringMissing('search');
            $b->assertMissing('@clear-search-link');

            $this->submitSearch($b, 'test');
            $b->assertQueryStringHas('search', 'test');
            $b->assertMissing($this->getCatByIdCardSelector($latestCat));
            $b->assertVisible('@clear-search-link');

            $b->click('@clear-search-link');
            $b->assertQueryStringMissing('search');
            $b->assertMissing('@clear-search-link');
            $b->assertVisible($this->getCatByIdCardSelector($latestCat));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_clearing_search_keeps_other_active_queries()
    {
        $this->browse(function (Browser $b) {
            $catName = 'test';
            $this->createCat(['name' => $catName]);

            $this->goToPage($b);
            $b->click('@per_page_' . Cat::PER_PAGE_12);
            $b->click('@id_sort_desc');
            $this->submitSearch($b, $catName);
            $b->assertQueryStringHas('search', $catName);
            $b->click('@clear-search-link');
            $b->assertQueryStringHas('per_page', Cat::PER_PAGE_12);
            $b->assertQueryStringHas('id', 'desc');
            $b->assertQueryStringMissing('search');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_per_page_options()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);

            foreach (Cat::PER_PAGE_OPTIONS as $option) {
                $selector = '@per_page_' . $option;
                $b->assertVisible($selector);
                $b->assertAttribute($selector, 'href', route('cat_list', ['per_page' => $option]));
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function test_doesnt_show_per_page_options_if_there_is_less_than_2_pages()
    {
        $this->browse(function (Browser $b) {
            Cat::factory()->count(Cat::PER_PAGE_12)->create(['name' => 'hello123']);
            Cat::factory()->count(Cat::PER_PAGE_12 + 1)->create(['name' => 'hello456']);

            $this->goToPage($b);
            $b->assertVisible('@per_page-options-wrapper');

            $this->submitSearch($b, 'hello123');
            $b->assertMissing('@per_page-options-wrapper');

            $this->submitSearch($b, 'hello456');
            $b->assertVisible('@per_page-options-wrapper');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_doesnt_show_24_per_page_option_if_there_are_fewer_than_24_results()
    {
        $this->browse(function (Browser $b) {
            Cat::factory()->count(Cat::PER_PAGE_24 - 1)->create(['name' => 'asdasdasd123']);
            Cat::factory()->count(Cat::PER_PAGE_24)->create(['name' => 'asdasdasd456']);

            $this->goToPage($b);
            $b->assertVisible('@per_page_' . Cat::PER_PAGE_24);

            $this->submitSearch($b, 'asdasdasd123');
            $b->assertMissing('@per_page_' . Cat::PER_PAGE_24);

            $this->submitSearch($b, 'asdasdasd456');
            $b->assertVisible('@per_page_' . Cat::PER_PAGE_24);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_clicking_per_page_links_works()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->assertCount(Cat::PER_PAGE_12, $b->elements('@cat-list-item'));
            $b->assertQueryStringMissing('per_page');
            $b->click('@per_page_' . Cat::PER_PAGE_24);
            $this->assertCount(Cat::PER_PAGE_24, $b->elements('@cat-list-item'));
            $b->assertQueryStringHas('per_page', Cat::PER_PAGE_24);
            $b->click('@per_page_' . Cat::PER_PAGE_12);
            $this->assertCount(Cat::PER_PAGE_12, $b->elements('@cat-list-item'));
            $b->assertQueryStringHas('per_page', Cat::PER_PAGE_12);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_per_page_links_respect_other_active_queries()
    {
        $this->browse(function (Browser $b) {
            $catName = 'test';
            Cat::factory()->count(Cat::PER_PAGE_24 + 1)->create(['name' => $catName]);

            foreach (static::SORT_FIELDS as $sort) {
                foreach (static::SORT_DIRECTIONS as $direction) {
                    $this->goToPage($b);
                    $this->submitSearch($b, $catName);
                    $b->click("@{$sort}_sort_{$direction}");

                    foreach (Cat::PER_PAGE_OPTIONS as $perPage) {
                        $b->assertAttribute(
                            "@per_page_{$perPage}",
                            'href',
                            route('cat_list') . "?per_page=${perPage}&{$sort}={$direction}&search={$catName}"
                        );
                    }
                }
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function test_active_per_page_link_is_highlighted()
    {
        $this->browse(function (Browser $b) {
            $activeOptionClass = 'per-page-option--active';

            $this->goToPage($b);
            $this->assertHasClass($b, '@per_page_' . Cat::PER_PAGE_12, $activeOptionClass);
            $this->assertNotHasClass($b, '@per_page_' . Cat::PER_PAGE_ALL, $activeOptionClass);
            $this->assertNotHasClass($b, '@per_page_' . Cat::PER_PAGE_ALL, $activeOptionClass);

            $b->click('@per_page_' . Cat::PER_PAGE_24);
            $this->assertHasClass($b, '@per_page_' . Cat::PER_PAGE_24, $activeOptionClass);
            $this->assertNotHasClass($b, '@per_page_' . Cat::PER_PAGE_12, $activeOptionClass);
            $this->assertNotHasClass($b, '@per_page_' . Cat::PER_PAGE_ALL, $activeOptionClass);

            $b->click('@per_page_' . Cat::PER_PAGE_ALL);
            $this->assertHasClass($b, '@per_page_' . Cat::PER_PAGE_ALL, $activeOptionClass);
            $this->assertNotHasClass($b, '@per_page_' . Cat::PER_PAGE_12, $activeOptionClass);
            $this->assertNotHasClass($b, '@per_page_' . Cat::PER_PAGE_24, $activeOptionClass);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_clicking_per_page_link_resets_to_page_1()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->click('@pagination-link-page-2');
            $b->assertQueryStringHas('page', 2);
            $b->click('@per_page_' . Cat::PER_PAGE_24);
            $b->assertQueryStringHas('per_page', Cat::PER_PAGE_24);
            $b->assertQueryStringMissing('page');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_sponsorship_count_sort_links_work()
    {
        $this->browse(function (Browser $b) {
            $this->createCatWithSponsorships([], 0);
            $this->createCatWithSponsorships([], 99);

            // Toggle
            $this->goToPage($b);
            $b->assertQueryStringMissing('sponsorship_count');
            $b->click('@sponsorship_count_sort_toggle');
            $b->assertQueryStringHas('sponsorship_count', 'asc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) {
                $this->assertEquals(0, $b->text('@cat-list-item-sponsorship-count'));
            });
            $b->click('@sponsorship_count_sort_toggle');
            $b->assertQueryStringHas('sponsorship_count', 'desc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) {
                $this->assertEquals(99, $b->text('@cat-list-item-sponsorship-count'));
            });
            $b->click('@sponsorship_count_sort_toggle');
            $b->assertQueryStringHas('sponsorship_count', 'asc');

            // Arrows
            $this->goToPage($b);
            $b->assertQueryStringMissing('sponsorship_count');
            $b->click('@sponsorship_count_sort_asc');
            $b->assertQueryStringHas('sponsorship_count', 'asc');
            $b->click('@sponsorship_count_sort_desc');
            $b->assertQueryStringHas('sponsorship_count', 'desc');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_date_of_birth_sort_links_work()
    {
        $this->browse(function (Browser $b) {
            $oldest = $this->createCat(['date_of_birth' => Carbon::now()->subYears(300)]);
            $youngest = $this->createCat(['date_of_birth' => Carbon::now()]);

            // Toggle
            $this->goToPage($b);
            $b->assertQueryStringMissing('age');
            $b->click('@age_sort_toggle');
            $b->assertQueryStringHas('age', 'asc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) use ($youngest) {
                $this->assertEquals($youngest->name, $b->text('@cat-list-item-name'));
            });
            $b->click('@age_sort_toggle');
            $b->assertQueryStringHas('age', 'desc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) use ($oldest) {
                $this->assertEquals($oldest->name, $b->text('@cat-list-item-name'));
            });
            $b->click('@age_sort_toggle');
            $b->assertQueryStringHas('age', 'asc');

            // Arrows
            $this->goToPage($b);
            $b->assertQueryStringMissing('age');
            $b->click('@age_sort_asc');
            $b->assertQueryStringHas('age', 'asc');
            $b->click('@age_sort_desc');
            $b->assertQueryStringHas('age', 'desc');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_id_sort_links_work()
    {
        $this->browse(function (Browser $b) {
            /** @var Cat $first */
            $first = Cat::orderBy('id')->first();
            /** @var Cat $latest */
            $latest = Cat::orderBy('id', 'desc')->first();

            // Toggle
            $this->goToPage($b);
            $b->assertQueryStringMissing('id');
            $b->click('@id_sort_toggle');
            $b->assertQueryStringHas('id', 'asc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) use ($first) {
                $this->assertEquals($first->name, $b->text('@cat-list-item-name'));
            });
            $b->click('@id_sort_toggle');
            $b->assertQueryStringHas('id', 'desc');
            $b->with('[dusk="cat-list-item-wrapper"]:first-of-type', function (Browser $b) use ($latest) {
                $this->assertEquals($latest->name, $b->text('@cat-list-item-name'));
            });
            $b->click('@id_sort_toggle');
            $b->assertQueryStringHas('id', 'asc');

            // Arrows
            $this->goToPage($b);
            $b->assertQueryStringMissing('id');
            $b->click('@id_sort_asc');
            $b->assertQueryStringHas('id', 'asc');
            $b->click('@id_sort_desc');
            $b->assertQueryStringHas('id', 'desc');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_highlights_active_sort_links()
    {
        $this->browse(function (Browser $b) {
            $activeArrowClass = 'sort-link-arrow--active';
            $activeToggleClass = 'sort-link-toggle--active';

            $this->goToPage($b);

            $sortOptions = ['sponsorship_count', 'age', 'id'];

            foreach ($sortOptions as $sort) {
                $this->assertNotHasClass($b, "@{$sort}_sort_asc", $activeArrowClass);
                $this->assertNotHasClass($b, "@{$sort}_sort_desc", $activeArrowClass);
                $this->assertNotHasClass($b, "@{$sort}_sort_toggle", $activeToggleClass);
            }

            foreach ($sortOptions as $sort) {
                $b->click("@{$sort}_sort_asc");
                $this->assertHasClass($b, "@{$sort}_sort_asc", $activeArrowClass);
                $this->assertNotHasClass($b, "@{$sort}_sort_desc", $activeArrowClass);
                $this->assertHasClass($b, "@{$sort}_sort_toggle", $activeToggleClass);

                $b->click("@{$sort}_sort_desc");
                $this->assertHasClass($b, "@{$sort}_sort_desc", $activeArrowClass);
                $this->assertNotHasClass($b, "@{$sort}_sort_asc", $activeArrowClass);
                $this->assertHasClass($b, "@{$sort}_sort_toggle", $activeToggleClass);
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function test_sort_links_respect_other_active_queries()
    {
        $this->browse(function (Browser $b) {
            $catName = 'test';
            Cat::factory()->count(Cat::PER_PAGE_24 + 1)->create(['name' => $catName]);

            foreach (Cat::PER_PAGE_OPTIONS as $perPage) {
                foreach (static::SORT_FIELDS as $sort) {
                    foreach (static::SORT_DIRECTIONS as $direction) {
                        $b->visitRoute('cat_list', ['per_page' => $perPage, 'search' => $catName]);

                        $b->assertAttribute(
                            "@{$sort}_sort_toggle",
                            'href',
                            route('cat_list') . "?per_page={$perPage}&search={$catName}&{$sort}=asc"
                        );

                        $b->assertAttribute(
                            "@{$sort}_sort_{$direction}",
                            'href',
                            route('cat_list') . "?per_page={$perPage}&search={$catName}&{$sort}={$direction}"
                        );
                    }
                }
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function test_sort_links_arent_shown_if_there_are_fewer_than_2_results()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat(['name' => 'sdfsdfsdfsdfsdfsdfsdf']);
            $this->goToPage($b);
            $b->assertVisible('@sort-options-wrapper');

            $this->submitSearch($b, $cat->name);
            $b->assertMissing('@sort-options-wrapper');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_no_results_message()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->assertVisible('@cat-list-items');

            $this->submitSearch($b, 'xxxxxyxyxyxyxyxyxyxyxy');
            $b->assertMissing('@cat-list-items');
            $b->assertSee('Za vaše iskanje ni bilo najdenih rezultatov.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_doesnt_show_per_page_or_sort_options_if_there_are_no_cats()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->assertVisible('@per_page-options-wrapper');
            $b->assertVisible('@sort-options-wrapper');

            $this->submitSearch($b, 'xxxxxyxyxyxyxyxyxyxyxy');
            $b->assertMissing('@per_page-options-wrapper');
            $b->assertMissing('@sort-options-wrapper');
        });
    }

    protected function getCatByIdCardSelector(Cat $cat): string
    {
        return '[dusk="cat-list-item"][data-cat-id="' . $cat->id . '"]';
    }

    protected function submitSearch(Browser $browser, string $search)
    {
        $browser->type('@search-input', $search);
        $browser->click('@search-submit');
        $browser->on(new CatListPage);
    }

    protected function goToPage(Browser $browser, string $query = ''): Browser
    {
        return $browser->visit((new CatListPage)->url() . $query);
    }
}
