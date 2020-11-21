<?php

namespace Tests\Browser;

use App\Models\Cat;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatSponsorshipFormPage;
use Tests\DuskTestCase;
use Throwable;

class CatSponsorshipFormTest extends DuskTestCase
{
    /**
     * @var Cat
     */
    protected $cat;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->cat = $this->createCat();
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_association_to_correct_cat()
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
