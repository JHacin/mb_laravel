<?php

namespace Tests\Browser;

use App\Models\Cat;
use App\Models\PersonData;
use App\Services\CatPhotoService;
use App\Utilities\AgeFormat;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatDetailsPage;
use Tests\Browser\Pages\CatSponsorshipFormPage;
use Tests\DuskTestCase;
use Throwable;

class CatDetailsTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_individual_cat_details()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCatWithPhotos([
                'date_of_arrival_boter' => '2005-12-20',
                'date_of_arrival_mh' => '2000-01-01',
                'date_of_birth' => '1990-06-05',
                'is_group' => false,
            ]);
            $this->goToPage($b, $cat);

            $b->assertSeeIn('@cat-details-name', $cat->name);
            $b->assertSeeIn('@cat-details-date_of_arrival_boter', '20. 12. 2005');
            $b->assertSeeIn(
                '@cat-details-current_age',
                AgeFormat::formatToAgeString($cat->date_of_birth->diff(Carbon::now()))
            );
            $b->assertSeeIn('@cat-details-date_of_arrival_mh', 'januar 2000');
            $b->assertSeeIn('@cat-details-age_on_arrival_mh', '9 let in 6 mesecev');
            $b->assertSeeIn('@cat-details-gender_label', $cat->gender_label);
            $b->assertSeeIn('@cat-details-become-sponsor-form-link', 'Postani moj boter');
            $b->assertSeeIn('@cat-details-story-title', 'Moja zgodba');
            $b->assertSeeIn('@cat-details-story', $cat->story);
            $b->assertSeeIn('@cat-details-sponsor-list-title', 'Moji botri');

            foreach (CatPhotoService::INDICES as $index) {
                $b->assertAttribute(
                    '@cat-details-photo-' . $index,
                    'src',
                    env('APP_URL') . $cat->getPhotoByIndex($index)->url,
                );
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_different_content_for_groups()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCatWithPhotos(['is_group' => true]);
            $this->goToPage($b, $cat);

            $b->assertSeeIn('@cat-details-name', $cat->name);
            $b->assertMissing('@cat-details-date_of_arrival_boter');
            $b->assertMissing('@cat-details-current_age');
            $b->assertMissing('@cat-details-date_of_arrival_mh');
            $b->assertMissing('@cat-details-age_on_arrival_mh');
            $b->assertMissing('@cat-details-gender_label');
            $b->assertSeeIn('@cat-details-become-sponsor-form-link', 'Postani boter');
            $b->assertMissing('@cat-details-story-title');
            $b->assertSeeIn('@cat-details-story', $cat->story);
            $b->assertSeeIn('@cat-details-sponsor-list-title', 'Trenutni botri');

            foreach (CatPhotoService::INDICES as $index) {
                $b->assertAttribute(
                    '@cat-details-photo-' . $index,
                    'src',
                    env('APP_URL') . $cat->getPhotoByIndex($index)->url,
                );
            }
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_fallback_for_missing_values()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat([
                'date_of_arrival_boter' => null,
                'date_of_arrival_mh' => null,
                'date_of_birth' => null,
                'is_group' => false,
            ]);
            $this->goToPage($b, $cat);

            $fallback = '/';
            $b->assertSeeIn('@cat-details-date_of_arrival_boter', $fallback);
            $b->assertSeeIn('@cat-details-current_age', $fallback);
            $b->assertSeeIn('@cat-details-date_of_arrival_mh', $fallback);
            $b->assertSeeIn('@cat-details-age_on_arrival_mh', $fallback);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_sponsor_list()
    {
        $this->browse(function (Browser $b) {
            $catWithoutSponsors = $this->createCat(['is_group' => false]);
            $this->goToPage($b, $catWithoutSponsors);
            $b->assertSeeIn('@cat-details-sponsor-list', 'Muca še nima botrov.');

            $catWithSponsors = $this->createCatWithSponsorships();
            $this->goToPage($b, $catWithSponsors);
            $b->assertDontSeeIn('@cat-details-sponsor-list', 'Muca še nima botrov.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_sponsor_list_is_formatted_correctly()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat();

            $this->createSponsorship(['cat_id' => $cat->id, 'is_active' => false]);
            $this->createSponsorship(['cat_id' => $cat->id, 'is_anonymous' => true]);

            $fullPD = PersonData::factory()->state(['first_name' => 'Vinko', 'city' => 'Rovte']);
            $this->createSponsorship(['cat_id' => $cat->id, 'person_data_id' => $fullPD]);

            $noFirstNamePD = PersonData::factory()->state(['first_name' => null, 'city' => 'Vrhnika']);
            $this->createSponsorship(['cat_id' => $cat->id, 'person_data_id' => $noFirstNamePD]);

            $noCityPD = PersonData::factory()->state(['first_name' => 'Janez', 'city' => null]);
            $this->createSponsorship(['cat_id' => $cat->id, 'person_data_id' => $noCityPD]);

            $unknownPD = PersonData::factory()->state(['first_name' => null, 'city' => null]);
            $this->createSponsorship(['cat_id' => $cat->id, 'person_data_id' => $unknownPD]);

            $this->goToPage($b, $cat);
            $b->assertSeeIn('@cat-details-sponsor-list', 'Vinko, Rovte');
            $b->assertSeeIn('@cat-details-sponsor-list', 'brez imena, Vrhnika');
            $b->assertSeeIn('@cat-details-sponsor-list', 'Janez, neznan kraj');
            $b->assertSeeIn('@cat-details-sponsor-list', '2 anonimna botra');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_button_click_goes_to_sponsorship_form()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat();
            $this->goToPage($b, $cat);
            $b->click('@cat-details-become-sponsor-form-link');
            $b->on(new CatSponsorshipFormPage($cat));
        });
    }

    /**
     * @param Browser $b
     * @param Cat $cat
     */
    protected function goToPage(Browser $b, Cat $cat)
    {
        $b->visit(new CatDetailsPage($cat));
    }
}
