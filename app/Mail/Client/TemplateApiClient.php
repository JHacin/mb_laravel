<?php

namespace App\Mail\Client;

use Http;

class TemplateApiClient
{
    public function retrieveTemplate(string $templateId): string
    {
        $requestUrl =
            env('MAILGUN_ENDPOINT') .
            '/v3/' .
            env('MAILGUN_DOMAIN') .
            '/templates/' .
            $templateId;

        $client = Http::withBasicAuth('api', env('MAILGUN_SECRET'));
        $response = $client->get($requestUrl, ['active' => 'yes']);

        if (!$response->successful()) {
            $status = $response->status();
            $message = $status === 404
                ? 'Predloga s to šifro ne obstaja.'
                : 'Prišlo je do napake pri pridobivanju podatkov o predlogi sporočila.';

            abort($status, $message);
        }

        return $response->json()['template']['version']['template'];
    }
}
