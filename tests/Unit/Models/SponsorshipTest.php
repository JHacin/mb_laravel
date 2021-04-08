<?php

namespace Tests\Unit\Models;

use App\Models\Sponsorship;
use Mockery;
use Tests\TestCase;

class SponsorshipTest extends TestCase
{
    protected Sponsorship $sponsorship;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->sponsorship = $this->createSponsorship();
    }

    public function test_filters_out_inactive_sponsorships_by_default()
    {
        $this->sponsorship->update(['is_active' => false]);
        $this->assertFalse(Sponsorship::all()->contains($this->sponsorship->id));
        $this->assertTrue(Sponsorship::withoutGlobalScopes()->get()->contains($this->sponsorship->id));

        $this->sponsorship->update(['is_active' => true]);
        $this->assertTrue(Sponsorship::all()->contains($this->sponsorship->id));
    }

    public function test_returns_correct_payment_reference_number()
    {
        $fieldGeneratorMock = Mockery::mock('alias:App\Utilities\BankTransferFieldGenerator');

        $fieldGeneratorMock
            ->shouldReceive('referenceNumber')
            ->once()
            ->with($this->sponsorship)
            ->andReturn('MOCK_REF');

        $this->assertEquals('MOCK_REF', $this->sponsorship->payment_reference_number);
    }
}
