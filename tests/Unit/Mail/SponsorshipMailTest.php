<?php

namespace Tests\Unit\Mail;

use App\Models\Sponsorship;
use App\Utilities\CountryList;
use App\Utilities\CurrencyFormat;
use MailClient;
use SponsorshipMail;
use Tests\TestCase;

class SponsorshipMailTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_initial_instructions_email_with_correct_params()
    {
        $sponsorship = $this->createSponsorship(['payment_type' => Sponsorship::PAYMENT_TYPE_BANK_TRANSFER]);
        $personData = $sponsorship->personData;
        $cat = $sponsorship->cat;

        $baseParams = [
            'to' => $personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
            'v:app_url' => env('APP_URL'),
            'v:faq_url' => url(route('faq')),
            'v:boter_ime' => $personData->first_name ?? '/',
            'v:boter_priimek' => $personData->last_name ?? '/',
            'v:boter_naslov' => $personData->address ?? '/',
            'v:boter_postna_stevilka' => $personData->zip_code ?? '/',
            'v:boter_kraj' => $personData->city ?? '/',
            'v:boter_drzava' => $personData->country ? CountryList::COUNTRY_NAMES[$personData->country] : '/',
            'v:boter_email' => $personData->email,
            'v:znesek' => CurrencyFormat::format($sponsorship->monthly_amount),
            'v:muca_ime' => $cat->name,
            'v:muca_povezava' => url(route('cat_details', $cat)),
            'v:namen_nakazila' => 'BOTER-' . strtoupper(str_replace(' ', '-', $cat->name)) . '-' . $cat->id,
            'v:referencna_stevilka' => 'PLACEHOLDER_REF',
        ];

        MailClient::shouldReceive('send')
            ->once()
            ->with(array_merge($baseParams, ['template' => 'navodila_za_botrovanje_nakazilo']));
        SponsorshipMail::sendInitialInstructionsEmail($sponsorship);

        MailClient::shouldReceive('send')
            ->once()
            ->with(array_merge($baseParams, ['template' => 'navodila_za_botrovanje_trajnik']));
        $sponsorship->update(['payment_type' => Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT]);
        SponsorshipMail::sendInitialInstructionsEmail($sponsorship);
    }
}
