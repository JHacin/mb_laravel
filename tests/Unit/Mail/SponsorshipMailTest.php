<?php

namespace Tests\Unit\Mail;

use App\Mail\Client\MailClient;
use App\Mail\SponsorshipMail;
use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Utilities\CountryList;
use App\Utilities\CurrencyFormat;
use Illuminate\Contracts\Container\BindingResolutionException;
use Storage;
use Tests\TestCase;

class SponsorshipMailTest extends TestCase
{
    /**
     * @throws BindingResolutionException
     */
    public function test_sends_initial_instructions_email_with_correct_params()
    {
        $mailClientMock = $this->mock(MailClient::class);
        $sponsorship = $this->createSponsorship([
            'cat_id' => $this->createCat()->id, //Todo: figure out why the test fails if this is removed
            'payment_type' => Sponsorship::PAYMENT_TYPE_BANK_TRANSFER
        ]);
        $personData = $sponsorship->sponsor;
        $cat = $sponsorship->cat;

        $expectedVariables = [
            'app_url' => config('app.url'),
            'faq_url' => url(route('faq')),
            'boter_moski' => $personData->gender === PersonData::GENDER_MALE,
            'boter_ime' => $personData->first_name ?? '/',
            'boter_priimek' => $personData->last_name ?? '/',
            'boter_naslov' => $personData->address ?? '/',
            'boter_postna_stevilka' => $personData->zip_code ?? '/',
            'boter_kraj' => $personData->city ?? '/',
            'boter_drzava' => $personData->country ? CountryList::COUNTRY_NAMES[$personData->country] : '/',
            'boter_email' => $personData->email,
            'znesek' => CurrencyFormat::format($sponsorship->monthly_amount),
            'muca_ime' => $cat->name,
            'muca_povezava' => url(route('cat_details', $cat)),
            'namen_nakazila' => $sponsorship->payment_purpose,
            'referencna_stevilka' => $sponsorship->payment_reference_number,
        ];

        $expectedParams = [
            'to' => $personData->email,
            'bcc' => config('mail.vars.bcc_copy_address'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
            'template' => 'navodila_za_botrstvo_nakazilo',
            'h:X-Mailgun-Variables' => json_encode($expectedVariables),
        ];

        // PAYMENT_TYPE_BANK_TRANSFER
        $expectedParams = array_merge($expectedParams, ['template' => 'navodila_za_botrstvo_nakazilo']);
        $mailClientMock->shouldReceive('send')->once()->with($expectedParams);
        $this->app->make(SponsorshipMail::class)->sendInitialInstructionsEmail($sponsorship);

        // PAYMENT_TYPE_DIRECT_DEBIT
        $expectedParams = array_merge(
            $expectedParams,
            [
                'template' => 'navodila_za_botrstvo_trajnik',
                'attachment' => [
                    [
                        'filePath' => Storage::disk('public')->path('docs/trajnik_pooblastilo.pdf'),
                        'filename' => 'trajnik_pooblastilo.pdf',
                    ]
                ],
            ]
        );
        $mailClientMock->shouldReceive('send')->once()->with($expectedParams);
        $sponsorship->update(['payment_type' => Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT]);
        $this->app->make(SponsorshipMail::class)->sendInitialInstructionsEmail($sponsorship);

        // MALE SPONSOR
        $expectedVariables = array_merge($expectedVariables, ['boter_moski' => true]);
        $expectedParams = array_merge($expectedParams, ['h:X-Mailgun-Variables' => json_encode($expectedVariables)]);
        $personData->update(['gender' => PersonData::GENDER_MALE]);
        $mailClientMock->shouldReceive('send')->once()->with($expectedParams);
        $this->app->make(SponsorshipMail::class)->sendInitialInstructionsEmail($sponsorship);

        // FEMALE SPONSOR
        $expectedVariables = array_merge($expectedVariables, ['boter_moski' => false]);
        $expectedParams = array_merge($expectedParams, ['h:X-Mailgun-Variables' => json_encode($expectedVariables)]);
        $personData->update(['gender' => PersonData::GENDER_FEMALE]);
        $mailClientMock->shouldReceive('send')->once()->with($expectedParams);
        $this->app->make(SponsorshipMail::class)->sendInitialInstructionsEmail($sponsorship);
    }
}
