<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageTypeListPage;
use Throwable;

class AdminSponsorshipMessageTypeListTest extends AdminTestCase
{
    /**
     * @throws Throwable
     */
    public function test_shows_message_type_details_correctly()
    {
        $this->browse(function (Browser $b) {
            $messageType = $this->createSponsorshipMessageType();
            $this->goToPage($b);
            $this->openFirstRowDetails($b);

            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($messageType) {
                $this->assertDetailsModalShowsValuesInOrder($b, [
                    0 => $messageType->id,
                    1 => $messageType->name,
                    2 => $messageType->template_id,
                    3 => $messageType->is_active ? 'Da' : 'Ne',
                ]);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_deletes_message_type()
    {
        $this->browse(function (Browser $b) {
            $messageType = $this->createSponsorshipMessageType();
            $this->goToPage($b);

            $b->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) use ($messageType) {
                $browser
                    ->assertSee($messageType->name)
                    ->click('a[data-button-type="delete"]');
            });
            $b->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Izbriši');
            });

            $this->waitForRequestsToFinish($b);
            $b->assertDontSee($messageType->name);
            $this->assertDatabaseMissing('sponsorship_message_types', ['id' => $messageType->id]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_doesnt_show_create_edit_or_delete_buttons_to_non_super_admins()
    {
        $this->browse(function (Browser $b) {
            $user = $this->createNonSuperAdminUser();
            $this->goToPage($b, $user);

            $b->assertMissing('.crud-create-button'); // create btn below title
            $b->with('#crudTable', function (Browser $b) {
                $b->assertMissing('.la.la-edit'); // actions - edit button
                $b->assertMissing('[data-button-type="delete"]'); // actions - delete button
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_search_works()
    {
        $this->browse(function (Browser $b) {
            $shown = $this->createSponsorshipMessageType([
                'name' => 'a_name_' . time(),
                'template_id' => 'a_template_id_' . time(),
            ]);
            $hidden = $this->createSponsorshipMessageType([
                'name' => 'b_name_' . time(),
                'template_id' => 'b_template_id_' . time(),
            ]);
            $this->goToPage($b);

            $searches = [
                $shown->name,
                $shown->template_id,
            ];

            foreach ($searches as $value) {
                $this->enterSearchInputValue($b, $value);
                $b->with('@crud-table-body', function (Browser $browser) use ($shown, $hidden) {
                    $browser
                        ->assertSee($shown->name)
                        ->assertSee($shown->template_id)
                        ->assertDontSee($hidden->name)
                        ->assertDontSee($hidden->template_id);
                });
            }
        });
    }

    /**
     * @param Browser $b
     * @param User|null $user
     * @throws TimeoutException
     */
    protected function goToPage(Browser $b, User $user = null)
    {
        $b->loginAs($user ?: static::$defaultAdmin);
        $b->visit(new AdminSponsorshipMessageTypeListPage);

        $this->waitForRequestsToFinish($b);
        $this->clearActiveFilters($b);
    }
}
