<?php

namespace App\Services;

use App\Mail\CatSponsorshipInitialInstructionsMail;
use App\Models\PersonData;
use Exception;
use Illuminate\Support\Facades\Mail;

class CatSponsorshipMailService extends MailService
{
    /**
     * @param PersonData $personData
     */
    public function sendInitialInstructionsEmail(PersonData $personData)
    {
        try {
            Mail::to($personData->email)
                ->bcc($this->bccCopyAddress)
                ->send(new CatSponsorshipInitialInstructionsMail);
        } catch (Exception $e) {
            $this->logException($e);
        }
    }
}
