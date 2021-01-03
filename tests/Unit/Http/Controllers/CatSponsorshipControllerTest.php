<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CatSponsorshipController;
use App\Http\Requests\CatSponsorshipRequest;
use App\Services\SponsorshipMailService;
use Mockery;
use Tests\TestCase;

class CatSponsorshipControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_initial_instructions_email_on_form_submit()
    {
        $cat = $this->createCat();
        $personData = $this->createPersonData();
        $requestMock = Mockery::mock(CatSponsorshipRequest::class);
        $mailServiceMock = Mockery::mock(SponsorshipMailService::class);

        $requestMock
            ->shouldReceive([
                'all' => [
                    'monthly_amount' => 5,
                ],
                'input' => $personData->toArray(),
            ])
            ->once();


        $mailServiceMock
            ->shouldReceive('sendInitialInstructionsEmail')
            ->once();

        $controller = new CatSponsorshipController($mailServiceMock);

        $controller->submit($cat, $requestMock);
    }
}
