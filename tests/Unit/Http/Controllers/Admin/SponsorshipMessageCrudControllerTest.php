<?php

namespace Tests\Unit\Http\Controllers\Admin;

use SponsorshipMessageHandler;
use Tests\TestCase;

class SponsorshipMessageCrudControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_email_on_submit()
    {
        SponsorshipMessageHandler::shouldReceive('send')->once();

        $this->actingAs($this->createSuperAdminUser())->post('admin/pisma', [
            'messageType' => $this->createSponsorshipMessageType()->id,
            'personData' => $this->createPersonData()->id,
            'cat' => $this->createCat()->id,
        ]);
    }
}
