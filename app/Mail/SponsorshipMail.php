<?php

namespace App\Mail;

use App\Mail\Client\MailClient;
use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Utilities\CountryList;
use App\Utilities\CurrencyFormat;
use Storage;

class SponsorshipMail
{
    private MailClient $mailClient;

    public function __construct(MailClient $mailClient)
    {
        $this->mailClient = $mailClient;
    }

    /**
     * @param \App\Models\Sponsorship $sponsorship
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function sendInitialInstructionsEmail(Sponsorship $sponsorship)
    {
        $template = $sponsorship->payment_type === Sponsorship::PAYMENT_TYPE_BANK_TRANSFER
            ? 'navodila_za_botrstvo_nakazilo'
            : 'navodila_za_botrstvo_trajnik';

        $sponsor = $sponsorship->sponsor;
        $payer = $sponsorship->payer ?? $sponsor;
        $cat = $sponsorship->cat;

        $variables = [
            'app_url' => config('app.url'),
            'boter_moski' => $sponsor->gender === PersonData::GENDER_MALE,
            'boter_ime' => $sponsor->first_name ?? '/',
            'boter_priimek' => $sponsor->last_name ?? '/',
            'boter_naslov' => $sponsor->address ?? '/',
            'boter_postna_stevilka' => $sponsor->zip_code ?? '/',
            'boter_kraj' => $sponsor->city ?? '/',
            'boter_drzava' => $sponsor->country ? CountryList::COUNTRY_NAMES[$sponsor->country] : '/',
            'boter_email' => $sponsor->email,
            'placnik_ime' => $payer->first_name ?? '/',
            'placnik_priimek' => $payer->last_name ?? '/',
            'placnik_naslov' => $payer->address ?? '/',
            'placnik_postna_stevilka' => $payer->zip_code ?? '/',
            'placnik_kraj' => $payer->city ?? '/',
            'placnik_drzava' => $payer->country ? CountryList::COUNTRY_NAMES[$payer->country] : '/',
            'placnik_email' => $payer->email,
            'muca_ime' => $cat->name,
            'muca_povezava' => url(route('cat_details', $cat)),
            'je_darilo' => $sponsorship->is_gift === true,
            'je_anonimno' => $sponsorship->is_anonymous === true,
            'znesek' => CurrencyFormat::format($sponsorship->monthly_amount),
            'namen_nakazila' => $sponsorship->payment_purpose,
            'referencna_stevilka' => $sponsorship->payment_reference_number,
        ];

        $params = [
            'to' => $sponsorship->sponsor->email,
            'bcc' => config('mail.vars.bcc_copy_address'),
            'subject' => 'Navodila po izpolnitvi obrazca za pristop k botrstvu',
            'template' => $template,
            'h:X-Mailgun-Variables' => json_encode($variables)
        ];

        if ($sponsorship->payment_type === Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT) {
            $params['attachment'] = [
                [
                    'filePath' => Storage::disk('public')->path('docs/trajnik_pooblastilo.pdf'),
                    'filename' => 'trajnik_pooblastilo.pdf',
                ]
            ];
        }

        $this->mailClient->send($params);
    }
}
