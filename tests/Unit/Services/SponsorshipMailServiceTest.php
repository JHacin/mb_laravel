<?php

namespace Tests\Unit\Services;

use App\Mail\MailClient;
use App\Services\SponsorshipMailService;
use Mockery;
use Tests\TestCase;

class SponsorshipMailServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_initial_instructions_email()
    {
        $mailClientMock = Mockery::mock(MailClient::class);
        $personData = $this->createPersonData();

        $mailClientMock
            ->shouldReceive('send')
            ->once()
            ->with([
                'to' => $personData->email,
                'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
                'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
                'template' => 'sponsorship_initial_instructions',
            ]);

        $service = new SponsorshipMailService($mailClientMock);

        $service->sendInitialInstructionsEmail($personData);
    }
}
