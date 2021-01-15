<?php

namespace Tests\Browser\Admin;

use App\Models\SponsorshipMessageType;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageTypeEditPage;
use Throwable;

class AdminSponsorshipMessageTypeEditTest extends AdminTestCase
{

    /**
     * @throws Throwable
     */
    public function test_shows_message_type_details()
    {
        $this->browse(function (Browser $b) {
            $messageType = $this->createSponsorshipMessageType();
            $this->goToPage($b, $messageType);

            $b->assertInputValue('name', $messageType->name);
            $b->assertInputValue('template_id', $messageType->template_id);
            $b->assertInputValue('is_active', $messageType->is_active);
        });
    }


    /**
     * @param Browser $browser
     * @param SponsorshipMessageType $messageType
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser, SponsorshipMessageType $messageType)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminSponsorshipMessageTypeEditPage($messageType));

        $this->waitForRequestsToFinish($browser);
    }
}
