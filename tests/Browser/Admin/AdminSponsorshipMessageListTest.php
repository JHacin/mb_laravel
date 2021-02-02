<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\SponsorshipMessageType;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatEditPage;
use Tests\Browser\Pages\Admin\AdminSponsorEditPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageListPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageTypeEditPage;
use Throwable;

class AdminSponsorshipMessageListTest extends AdminTestCase
{
    /**
     * @throws Throwable
     */
    public function test_shows_message_details()
    {
        $this->browse(function (Browser $b) {
            $msg = $this->createSponsorshipMessage();
            $this->goToPage($b);

            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($msg) {
                $this->assertDetailsModalShowsValuesInOrder($b, [
                    0 => $msg->id,
                    1 => $msg->messageType->name,
                    2 => $msg->personData->email_and_id,
                    3 => $msg->cat->name_and_id,
                    4 => $this->formatToDatetimeColumnString($msg->created_at),
                ]);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_clicking_on_message_type_link_opens_up_related_edit_form()
    {
        $this->browse(function (Browser $b) {
            $msg = $this->createSponsorshipMessage();
            $this->goToPage($b);
            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($msg) {
                $browser
                    ->click('tr[data-dt-column="1"] a')
                    ->on(new AdminSponsorshipMessageTypeEditPage($msg->messageType));
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_clicking_on_person_data_link_opens_up_related_edit_form()
    {
        $this->browse(function (Browser $b) {
            $msg = $this->createSponsorshipMessage();
            $this->goToPage($b);
            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($msg) {
                $browser
                    ->click('tr[data-dt-column="2"] a')
                    ->on(new AdminSponsorEditPage($msg->personData));
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_clicking_on_cat_link_opens_up_related_edit_form()
    {
        $this->browse(function (Browser $b) {
            $msg = $this->createSponsorshipMessage();
            $this->goToPage($b);
            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($msg) {
                $browser
                    ->click('tr[data-dt-column="3"] a')
                    ->on(new AdminCatEditPage($msg->cat));
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_filters_by_message_type()
    {
        $this->browse(function (Browser $b) {
            $shown = $this->createSponsorshipMessage(['message_type_id' => SponsorshipMessageType::factory()]);
            $hidden = $this->createSponsorshipMessage(['message_type_id' => SponsorshipMessageType::factory()]);
            $this->goToPage($b);

            $b->with('#bp-filters-navbar li[filter-name="messageType"]', function (Browser $b) use ($shown) {
                $b
                    ->click('a.dropdown-toggle')
                    ->select('filter_messageType', $shown->message_type_id);
            });

            $this->waitForRequestsToFinish($b);

            $b->with('@crud-table-body', function (Browser $b) use ($shown, $hidden) {
                $b
                    ->assertSee($shown->messageType->name)
                    ->assertDontSee($hidden->messageType->name);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_filters_by_person_data()
    {
        $this->browse(function (Browser $b) {
            $shown = $this->createSponsorshipMessage(['person_data_id' => PersonData::factory()]);
            $hidden = $this->createSponsorshipMessage(['person_data_id' => PersonData::factory()]);
            $this->goToPage($b);

            $b->with('#bp-filters-navbar li[filter-name="personData"]', function (Browser $b) use ($shown) {
                $b
                    ->click('a.dropdown-toggle')
                    ->select('filter_personData', $shown->person_data_id);
            });

            $this->waitForRequestsToFinish($b);

            $b->with('@crud-table-body', function (Browser $b) use ($shown, $hidden) {
                $b
                    ->assertSee($shown->personData->email_and_id)
                    ->assertDontSee($hidden->personData->email_and_id);
            });
        });
    }


    /**
     * @throws Throwable
     */
    public function test_filters_by_cat()
    {
        $this->browse(function (Browser $b) {
            $shown = $this->createSponsorshipMessage(['cat_id' => Cat::factory()]);
            $hidden = $this->createSponsorshipMessage(['cat_id' => Cat::factory()]);
            $this->goToPage($b);

            $b->with('#bp-filters-navbar li[filter-name="cat"]', function (Browser $b) use ($shown) {
                $b
                    ->click('a.dropdown-toggle')
                    ->select('filter_cat', $shown->cat_id);
            });

            $this->waitForRequestsToFinish($b);

            $b->with('@crud-table-body', function (Browser $b) use ($shown, $hidden) {
                $b
                    ->assertSee($shown->cat->name_and_id)
                    ->assertDontSee($hidden->cat->name_and_id);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_multiple_filters_work_together()
    {
        $this->browse(function (Browser $b) {
            $shown = $this->createSponsorshipMessage([
                'message_type_id' => SponsorshipMessageType::factory(),
                'person_data_id' => PersonData::factory(),
                'cat_id' => Cat::factory()
            ]);
            $hidden = $this->createSponsorshipMessage([
                'message_type_id' => SponsorshipMessageType::factory(),
                'person_data_id' => PersonData::factory(),
                'cat_id' => Cat::factory()
            ]);
            $this->goToPage($b);

            $b->with('#bp-filters-navbar li[filter-name="messageType"]', function (Browser $b) use ($shown) {
                $b
                    ->click('a.dropdown-toggle')
                    ->select('filter_messageType', $shown->message_type_id);
            });
            $this->waitForRequestsToFinish($b);

            $b->with('#bp-filters-navbar li[filter-name="personData"]', function (Browser $b) use ($shown) {
                $b
                    ->click('a.dropdown-toggle')
                    ->select('filter_personData', $shown->person_data_id);
            });
            $this->waitForRequestsToFinish($b);

            $b->with('#bp-filters-navbar li[filter-name="cat"]', function (Browser $b) use ($shown) {
                $b
                    ->click('a.dropdown-toggle')
                    ->select('filter_cat', $shown->cat_id);
            });
            $this->waitForRequestsToFinish($b);

            $b->with('@crud-table-body', function (Browser $b) use ($shown, $hidden) {
                $b
                    ->assertSee($shown->messageType->name)
                    ->assertSee($shown->personData->email_and_id)
                    ->assertSee($shown->cat->name_and_id)
                    ->assertDontSee($hidden->messageType->name)
                    ->assertDontSee($hidden->personData->email_and_id)
                    ->assertDontSee($hidden->cat->name_and_id);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_search_works()
    {
        $this->browse(function (Browser $b) {
            $shown = $this->createSponsorshipMessage([
                'message_type_id' => SponsorshipMessageType::factory(),
                'person_data_id' => PersonData::factory(),
                'cat_id' => Cat::factory()
            ]);
            $hidden = $this->createSponsorshipMessage([
                'message_type_id' => SponsorshipMessageType::factory(),
                'person_data_id' => PersonData::factory(),
                'cat_id' => Cat::factory()
            ]);
            $this->goToPage($b);

            $searches = [
                $shown->messageType->name,
                $shown->personData->email,
                $shown->cat->name,
            ];

            foreach ($searches as $value) {
                $this->enterSearchInputValue($b, $value);
                $b->with('@crud-table-body', function (Browser $browser) use ($shown, $hidden) {
                    $browser
                        ->assertSee($shown->messageType->name)
                        ->assertSee($shown->personData->email)
                        ->assertSee($shown->cat->name)
                        ->assertDontSee($hidden->messageType->name)
                        ->assertDontSee($hidden->personData->email)
                        ->assertDontSee($hidden->cat->name);
                });
            }
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

        $this->waitForRequestsToFinish($b);
        $this->clearActiveFilters($b);
    }
}
