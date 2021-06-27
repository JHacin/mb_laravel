<?php

namespace App\Utilities;

use App\Models\Sponsorship;

class BankTransferFieldGenerator
{
    public static function purpose(Sponsorship $sponsorship): string
    {
        $formattedCatName = mb_strtoupper(str_replace(' ', '-', $sponsorship->cat->name));

        return 'BOTER-' . $formattedCatName . '-' . $sponsorship->cat->id;
    }

    public static function referenceNumber(Sponsorship $sponsorship): string
    {
        return 'SI00 80-' . $sponsorship->cat_id . '-' . $sponsorship->sponsor_id;
    }
}
