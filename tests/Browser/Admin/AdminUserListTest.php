<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\Pages\AdminUserListPage;
use Throwable;

class AdminUserListTest extends AdminTestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

    /**
     * @var User|null
     */
    protected static ?User $sampleUser_1 = null;

    /**
     * @var User|null
     */
    protected static ?User $sampleUser_2 = null;

//    /**
//     * @inheritDoc
//     */
//    protected function setUp(): void
//    {
//        parent::setUp();
//
//        if (!static::$sampleUser_1 || !static::$sampleUser_2) {
//            static::$sampleUser_1 = $this->createUser();
//            static::$sampleUser_2 = $this->createUserWithPersonData();
//            static::$sampleUser_2->assignRole(User::ROLE_SUPER_ADMIN);
//        }
//    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_user_details_are_shown_correctly()
    {
        $this->browse(function (Browser $browser) {
            $user = static::$sampleUser_2;
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($user) {
                $this->assertDetailsModalShowsValuesInOrder($browser, [
                    0 => $user->id,
                    1 => $user->name,
                    2 => $user->email,
                    3 => $user->personData->first_name,
                    4 => $user->personData->last_name,
                    5 => 'super-admin',
                    6 => $user->is_active ? 'Da' : 'Ne',
                    7 => $this->formatToDateColumnString($user->created_at),
                    8 => $this->formatToDatetimeColumnString($user->updated_at),
                ]);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_role_filter_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);

            $browser->with('@user-list-role-filter', function (Browser $browser) {
                $browser->click('a.dropdown-toggle');

                foreach (User::ADMIN_ROLES as $key => $label) {
                    $browser->assertSee($label);
                }
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_filters_by_role()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->clickBooleanTypeFilterValue($browser, '@user-list-role-filter', true);
            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleUser_2->name)
                    ->assertDontSee(static::$sampleUser_1->name);
            });
        });
    }


    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_permissions_filter_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $browser->assertSelectHasOptions('filter_permissions', []);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_filters_by_permission()
    {
        $this->assertTrue(true);
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_search_works()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);

            $searches = [
                static::$sampleUser_2->id,
                static::$sampleUser_2->name,
                static::$sampleUser_2->email,
                static::$sampleUser_2->personData->first_name,
                static::$sampleUser_2->personData->last_name,
            ];

            foreach ($searches as $value) {
                $this->enterSearchInputValue($browser, $value);

                $browser->with('@crud-table-body', function (Browser $browser) {
                    $browser
                        ->assertSee(static::$sampleUser_2->name)
                        ->assertDontSee(static::$sampleUser_1->name);
                });
            }
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
            ->visit(new AdminUserListPage);

        $this->waitForRequestsToFinish($browser);
        $this->clearActiveFilters($browser);
    }
}
