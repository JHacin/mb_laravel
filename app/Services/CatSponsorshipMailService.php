<?php

namespace App\Services;

use App\Mail\CatSponsorshipInitialInstructionsMail;
use App\Models\PersonData;
use Exception;
use Illuminate\Support\Facades\Mail;

class CatSponsorshipMailService
{
    public static function sendInitialInstructionsEmail(PersonData $personData)
    {
        try {
            Mail::to($personData->email)->send(new CatSponsorshipInitialInstructionsMail);
        } catch (Exception $e) {
            // Todo: handle exception
        }
    }
}
