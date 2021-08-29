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

        $personData = $sponsorship->sponsor;
        $cat = $sponsorship->cat;

        $variables = [
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
