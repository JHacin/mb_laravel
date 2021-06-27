<?php

namespace Tests\Unit\Mail;

use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Utilities\BankTransferFieldGenerator;
use App\Utilities\CountryList;
use App\Utilities\CurrencyFormat;
use MailClient;
use SponsorshipMail;
use Storage;
use Tests\TestCase;

class SponsorshipMailTest extends TestCase
{
    public function test_sends_initial_instructions_email_with_correct_params()
    {
        $sponsorship = $this->createSponsorship([
            'cat_id' => $this->createCat()->id, //Todo: figure out why the test fails if this is removed
            'payment_type' => Sponsorship::PAYMENT_TYPE_BANK_TRANSFER
        ]);
        $personData = $sponsorship->sponsor;
        $cat = $sponsorship->cat;

        $expectedVariables = [
            'app_url' => env('APP_URL'),
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
            'namen_nakazila' => BankTransferFieldGenerator::purpose($sponsorship),
            'referencna_stevilka' => $sponsorship->payment_reference_number,
        ];

        $expectedParams = [
            'to' => $personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
            'template' => 'navodila_za_botrovanje_nakazilo',
            'h:X-Mailgun-Variables' => json_encode($expectedVariables),
        ];

        // PAYMENT_TYPE_BANK_TRANSFER
        $expectedParams = array_merge($expectedParams, ['template' => 'navodila_za_botrovanje_nakazilo']);
        MailClient::shouldReceive('send')->once()->with($expectedParams);
        SponsorshipMail::sendInitialInstructionsEmail($sponsorship);

        // PAYMENT_TYPE_DIRECT_DEBIT
        $expectedParams = array_merge(
            $expectedParams,
            [
                'template' => 'navodila_za_botrovanje_trajnik',
                'attachment' => [
                    [
                        'filePath' => Storage::disk('public')->path('docs/trajnik_pooblastilo.pdf'),
                        'filename' => 'trajnik_pooblastilo.pdf',
                    ]
                ],
            ]
        );
        MailClient::shouldReceive('send')->once()->with($expectedParams);
        $sponsorship->update(['payment_type' => Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT]);
        SponsorshipMail::sendInitialInstructionsEmail($sponsorship);

        // MALE SPONSOR
        $expectedVariables = array_merge($expectedVariables, ['boter_moski' => true]);
        $expectedParams = array_merge($expectedParams, ['h:X-Mailgun-Variables' => json_encode($expectedVariables)]);
        $personData->update(['gender' => PersonData::GENDER_MALE]);
        MailClient::shouldReceive('send')->once()->with($expectedParams);
        SponsorshipMail::sendInitialInstructionsEmail($sponsorship);

        // FEMALE SPONSOR
        $expectedVariables = array_merge($expectedVariables, ['boter_moski' => false]);
        $expectedParams = array_merge($expectedParams, ['h:X-Mailgun-Variables' => json_encode($expectedVariables)]);
        $personData->update(['gender' => PersonData::GENDER_FEMALE]);
        MailClient::shouldReceive('send')->once()->with($expectedParams);
        SponsorshipMail::sendInitialInstructionsEmail($sponsorship);
    }
}
