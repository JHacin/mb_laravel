<?php

namespace Tests\Unit\Mail\Client;

use App\Mail\Client\TemplateApiClient;
use Http;
use Illuminate\Http\Response;
use Mockery;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class TemplateApiClientTest extends TestCase
{
    public function test_retrieves_template_for_message_type()
    {
        $messageType = $this->createSponsorshipMessageType();

        Http::shouldReceive('withBasicAuth')
            ->once()
            ->with('api', config('services.mailgun.secret'))
            ->andReturnSelf();

        $requestUrl =
            config('services.mailgun.endpoint') .
            '/v3/' .
            config('services.mailgun.domain') .
            '/templates/' .
            $messageType->template_id;

        $responseMock = Mockery::mock(Response::class);

        Http::shouldReceive('get')
            ->once()
            ->with($requestUrl, ['active' => 'yes'])
            ->andReturn($responseMock);

        $responseMock
            ->shouldReceive('successful')
            ->once()
            ->andReturn(true);

        $responseMock
            ->shouldReceive('json')
            ->once()
            ->andReturn([
                'template' => [
                    'version' => [
                        'template' => 'template_text',
                    ]
                ]
            ]);

        $response = (new TemplateApiClient())->retrieveTemplate($messageType->template_id);

        $this->assertEquals('template_text', $response);
    }

    public function test_handles_not_found_template()
    {
        $messageType = $this->createSponsorshipMessageType();

        Http::fakeSequence()->push('', 404);
        $wasCaught = false;

        try {
            (new TemplateApiClient())->retrieveTemplate($messageType->template_id);
        } catch (NotFoundHttpException $exception) {
            $this->assertEquals(404, $exception->getStatusCode());
            $this->assertEquals('Predloga s to šifro ne obstaja.', $exception->getMessage());
            $wasCaught = true;
        }

        $this->assertTrue($wasCaught);
    }

    public function test_handles_server_error_when_retrieving_template()
    {
        $messageType = $this->createSponsorshipMessageType();

        Http::fakeSequence()->push('', 503);
        $wasCaught = false;

        try {
            (new TemplateApiClient())->retrieveTemplate($messageType->template_id);
        } catch (HttpException $exception) {
            $this->assertEquals(503, $exception->getStatusCode());
            $this->assertEquals(
                'Prišlo je do napake pri pridobivanju podatkov o predlogi sporočila.',
                $exception->getMessage()
            );
            $wasCaught = true;
        }

        $this->assertTrue($wasCaught);
    }
}
