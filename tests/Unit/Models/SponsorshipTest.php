<?php

namespace Tests\Unit\Models;

use App\Models\Sponsorship;
use Tests\TestCase;

class SponsorshipTest extends TestCase
{
    public function test_filters_out_inactive_sponsorships_by_default()
    {
        $sponsorship = $this->createSponsorship();

        $sponsorship->update(['is_active' => false]);
        $this->assertFalse(Sponsorship::all()->contains($sponsorship->id));
        $this->assertTrue(Sponsorship::withoutGlobalScopes()->get()->contains($sponsorship->id));

        $sponsorship->update(['is_active' => true]);
        $this->assertTrue(Sponsorship::all()->contains($sponsorship->id));
    }

    public function test_returns_correct_payment_purpose()
    {
        // without relations
        $this->assertEquals('/', $this->createSponsorship(['cat_id' => null])->payment_purpose);
        $this->assertNotEquals('/', $this->createSponsorshipWithCatAndSponsor()->payment_purpose);

        // with relations
        $sponsorship = $this->createSponsorshipWithCatAndSponsor();

        $sponsorship->cat->update(['name' => 'muca']);
        $this->assertEquals(
            'BOTER-MUCA-' . $sponsorship->cat_id,
            $sponsorship->payment_purpose
        );

        $sponsorship->cat->update(['name' => 'muca s presledki']);
        $this->assertEquals(
            'BOTER-MUCA-S-PRESLEDKI-' . $sponsorship->cat_id,
            $sponsorship->payment_purpose
        );

        $sponsorship->cat->update(['name' => 'muca čšž']);
        $this->assertEquals(
            'BOTER-MUCA-ČŠŽ-' . $sponsorship->cat_id,
            $sponsorship->payment_purpose
        );
    }

    public function test_returns_correct_payment_reference_number()
    {
        $sponsorship = $this->createSponsorship();

        // without relations
        $sponsorship->cat()->dissociate();
        $sponsorship->sponsor()->dissociate();
        $this->assertEquals('/', $sponsorship->payment_reference_number);

        $sponsorship->cat()->associate($this->createCat());
        $this->assertEquals('/', $sponsorship->payment_reference_number);

        // with relations
        $sponsorship->sponsor()->associate($this->createPersonData());
        $this->assertEquals(
            sprintf('SI00 80-0%s-%s', $sponsorship->cat_id, $sponsorship->sponsor_id),
            $sponsorship->payment_reference_number
        );
    }
}
