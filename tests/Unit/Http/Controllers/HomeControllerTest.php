<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Cat;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = false;

    /**
     * @throws Exception
     */
    public function test_returns_up_to_three_hero_cats_with_date_of_arrival_mh_and_photos()
    {
        $heroRequirements = [
            'date_of_arrival_mh' => Carbon::now(),
            'is_group' => false,
        ];

        // Clear out the cats table so we have a clean slate to test with.
        Cat::query()->delete();

        // Create cats with failing conditions so we know only the one with all conditions is returned.
        $withAllConditions = $this->createCatWithPhotos($heroRequirements);
        $this->createCat(); // without photos
        $this->createCatWithPhotos(array_merge($heroRequirements, ['date_of_arrival_mh' => null]));
        $this->createCatWithPhotos(array_merge($heroRequirements, ['is_group' => true]));
        $heroCats = $this->getHeroCatsResponse();
        /** @var Cat $returnedCat */
        $returnedCat = $heroCats->first();
        $this->assertCount(1, $heroCats);
        $this->assertEquals($withAllConditions->id, $returnedCat->id);
        $this->assertNotNull($returnedCat->date_of_arrival_mh);
        $this->assertTrue($returnedCat->photos()->count() >= 1);

        // Create 3 more cats with all conditions & assert that only 3 are returned out of 4 total.
        $this->createCatWithPhotos($heroRequirements);
        $this->createCatWithPhotos($heroRequirements);
        $this->createCatWithPhotos($heroRequirements);
        $heroCats = $this->getHeroCatsResponse();
        $this->assertCount(3, $heroCats);
        foreach ($heroCats as $cat) {
            $this->assertNotNull($cat->date_of_arrival_mh);
            $this->assertTrue($cat->photos()->count() >= 1);
        }
    }

    protected function getHeroCatsResponse(): Collection
    {
        $response = $this->get(route('home'));
        $response->assertViewHas('heroCats');

        return $response->getOriginalContent()->getData()['heroCats'];
    }
}
