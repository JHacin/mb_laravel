<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CatSponsorshipController;
use App\Http\Requests\CatSponsorshipRequest;
use App\Mail\SponsorshipMail;
use Illuminate\Contracts\Container\BindingResolutionException;
use Mockery;
use Tests\TestCase;

class CatSponsorshipControllerTest extends TestCase
{
    /**
     * @throws BindingResolutionException
     */
    public function test_sends_initial_instructions_email_on_form_submit()
    {
        $cat = $this->createCat();
        $personData = $this->createPersonData();
        $requestMock = Mockery::mock(CatSponsorshipRequest::class);

        $requestMock
            ->shouldReceive([
                'all' => [
                    'monthly_amount' => 5,
                    'personData' => $personData->toArray(),
                    'is_gift' => 'no',
                ],
            ])
            ->once();

        $this->mock(SponsorshipMail::class)->shouldReceive('sendInitialInstructionsEmail')->once();
        $this->app->make(CatSponsorshipController::class)->submit($cat, $requestMock);
    }
}
