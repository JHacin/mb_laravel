<?php

namespace App\Mail;

use App\Models\Sponsorship;
use App\Utilities\CountryList;
use App\Utilities\CurrencyFormat;
use MailClient;

class SponsorshipMail
{
    /**
     * @param \App\Models\Sponsorship $sponsorship
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function sendInitialInstructionsEmail(Sponsorship $sponsorship)
    {
        $template = $sponsorship->payment_type === Sponsorship::PAYMENT_TYPE_BANK_TRANSFER
            ? 'navodila_za_botrovanje_nakazilo'
            : 'navodila_za_botrovanje_trajnik';

        $personData = $sponsorship->personData;
        $cat = $sponsorship->cat;

        MailClient::send([
            'to' => $sponsorship->personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
            'template' => $template,
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
        ]);
    }
}
