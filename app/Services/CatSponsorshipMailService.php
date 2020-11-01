<?php

namespace App\Services;

use App\Mail\CatSponsorshipInitialInstructionsEmail;
use App\Models\PersonData;
use Exception;
use Illuminate\Support\Facades\Mail;

class CatSponsorshipMailService
{
    public static function sendInitialInstructionsEmail(PersonData $personData)
    {
        try {
            Mail::to($personData->email)->send(new CatSponsorshipInitialInstructionsEmail);
        } catch (Exception $e) {
            // Todo: handle exception
        }
    }
}
