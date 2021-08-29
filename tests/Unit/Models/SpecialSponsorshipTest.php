<?php

namespace Tests\Unit\Models;

use App\Models\SpecialSponsorship;
use Tests\TestCase;

class SpecialSponsorshipTest extends TestCase
{
    public function test_returns_correct_type_label()
    {
        $sponsorship = $this->createSpecialSponsorship();

        $sponsorship->update(['type' => SpecialSponsorship::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN]);
        $this->assertEquals(
            SpecialSponsorship::TYPE_LABELS[SpecialSponsorship::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN],
            $sponsorship->type_label
        );

        $sponsorship->update(['type' => SpecialSponsorship::TYPE_BOTER_MESECA]);
        $this->assertEquals(
            SpecialSponsorship::TYPE_LABELS[SpecialSponsorship::TYPE_BOTER_MESECA],
            $sponsorship->type_label
        );
    }

    public function test_returns_correct_payment_purpose()
    {
        $sponsorship = $this->createSpecialSponsorship(['type' => SpecialSponsorship::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN]);
        $this->assertEquals('POSEBNI-BOTER-7', $sponsorship->payment_purpose);
    }

    public function test_returns_correct_payment_reference_number()
    {
        $sponsorship = $this->createSpecialSponsorship(['type' => SpecialSponsorship::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN]);
        $this->assertEquals('SI00 80-17-' . $sponsorship->id, $sponsorship->payment_reference_number);


    }
}
