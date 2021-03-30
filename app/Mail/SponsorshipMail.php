<?php

namespace App\Mail;

use App\Models\PersonData;
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

        $variables = [
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
            'namen_nakazila' => 'BOTER-' . strtoupper(str_replace(' ', '-', $cat->name)) . '-' . $cat->id,
            'referencna_stevilka' => 'PLACEHOLDER_REF',
        ];

        MailClient::send([
            'to' => $sponsorship->personData->email,
            'bcc' => env('MAIL_BCC_COPY_ADDRESS'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
            'template' => $template,
            'h:X-Mailgun-Variables' => json_encode($variables),
        ]);
    }
}
