<?php

namespace Tests\Browser;

use App\Models\Cat;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatSponsorshipFormPage;
use Tests\DuskTestCase;
use Tests\Utilities\TestData\TestCatGarfield;
use Throwable;

class CatSponsorshipFormTest extends DuskTestCase
{
    /**
     * @var Cat
     */
    protected $cat;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cat = (new TestCatGarfield())->get();
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testAssociation()
    {
        $this->browse(function (Browser $browser) {
            $associationText = sprintf(
                'Ime živali, ki jo želite posvojiti na daljavo: %s (%s)',
                $this->cat->name,
                $this->cat->id
            );

            $browser
                ->visit(new CatSponsorshipFormPage($this->cat))
                ->assertSee($associationText);
        });
    }
}