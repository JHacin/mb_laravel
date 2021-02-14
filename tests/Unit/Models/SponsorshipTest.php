<?php

namespace Tests\Unit\Models;

use App\Models\Sponsorship;
use Tests\TestCase;

class SponsorshipTest extends TestCase
{
    /**
     * @var Sponsorship
     */
    protected Sponsorship $sponsorship;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->sponsorship = $this->createSponsorship();
    }

    /**
     * @return void
     */
    public function test_filters_out_inactive_sponsorships_by_default()
    {
        $this->sponsorship->update(['is_active' => false]);
        $this->assertFalse(Sponsorship::all()->contains($this->sponsorship->id));
        $this->assertTrue(Sponsorship::withoutGlobalScopes()->get()->contains($this->sponsorship->id));

        $this->sponsorship->update(['is_active' => true]);
        $this->assertTrue(Sponsorship::all()->contains($this->sponsorship->id));
    }
}
