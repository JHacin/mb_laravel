<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Cat;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CatListControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_returns_list_of_cats()
    {
        $response = $this->getResponse();
        $response->assertViewHas('cats');
    }

    public function test_doesnt_show_cats_with_hidden_from_public_statuses()
    {
        $hiddenFromPublicStatuses = [
            Cat::STATUS_NOT_SEEKING_SPONSORS,
            Cat::STATUS_ADOPTED,
            Cat::STATUS_RIP
        ];

        foreach (Cat::STATUSES as $status) {
            $cat = $this->createCat(['status' => $status]);
            $cats = $this->getCatsInResponse();

            if (in_array($status, $hiddenFromPublicStatuses)) {
                $this->assertFalse($cats->contains($cat->id));
            } else {
                $this->assertTrue($cats->contains($cat->id));
            }
        }
    }

    public function test_returns_12_cats_per_page_by_default()
    {
        $cats = $this->getCatsInResponse();

        $this->assertEquals(Cat::PER_PAGE_DEFAULT, $cats->perPage());
    }

    public function test_per_page_query_param_works()
    {
        foreach (Cat::PER_PAGE_OPTIONS as $option) {
            $cats = $this->getCatsInResponse(['per_page' => $option]);
            $this->assertEquals($option === 'all' ? Cat::count() : $option, $cats->perPage());
            $this->assertStringContainsString('per_page=' . $option, $cats->url(1));
        }
    }

    public function test_sorts_by_is_group_then_id_descending_by_default()
    {
        $name = 'name_' . time();

        $oldestNonGroupCat = $this->createCat(['is_group' => false, 'name' => $name]);
        $lastAddedIndividualCat = $this->createCat(['is_group' => false, 'name' => $name]);
        $lastAddedGroup = $this->createCat(['is_group' => true, 'name' => $name]);

        $cats = $this->getCatsInResponse(['search' => $name]);

        $this->assertEquals($cats[0]->id, $lastAddedGroup->id);
        $this->assertEquals($cats[1]->id, $lastAddedIndividualCat->id);
        $this->assertEquals($cats[2]->id, $oldestNonGroupCat->id);
    }

    public function test_sponsorship_count_sort_query_param_works()
    {
        $this->createCatWithSponsorships([], 0);
        $this->createCatWithSponsorships([], 99);

        $this->assertStringNotContainsString('sponsorship_count', $this->getCatsInResponse()->url(1));

        $catsAsc = $this->getCatsInResponse(['sponsorship_count' => 'asc']);
        $catsDesc = $this->getCatsInResponse(['sponsorship_count' => 'desc']);

        $this->assertEquals(0, $catsAsc->first()->sponsorships()->count());
        $this->assertStringContainsString('sponsorship_count=asc', $catsAsc->url(1));

        $this->assertEquals(99, $catsDesc->first()->sponsorships()->count());
        $this->assertStringContainsString('sponsorship_count=desc', $catsDesc->url(1));
    }

    public function test_age_sort_query_param_works()
    {
        $oldest = $this->createCat(['date_of_birth' => Carbon::now()->subYears(300)]);
        $youngest = $this->createCat(['date_of_birth' => Carbon::now()]);
        $this->createCat();

        $this->assertStringNotContainsString('age=asc', $this->getCatsInResponse()->url(1));
        $this->assertStringNotContainsString('age=desc', $this->getCatsInResponse()->url(1));

        $oldestFirst = $this->getCatsInResponse(['age' => 'desc']);
        $youngestFirst = $this->getCatsInResponse(['age' => 'asc']);

        $this->assertEquals($oldest->id, $oldestFirst->first()->id);
        $this->assertStringContainsString('age=desc', $oldestFirst->url(1));

        $this->assertEquals($youngest->id, $youngestFirst->first()->id);
        $this->assertStringContainsString('age=asc', $youngestFirst->url(1));
    }

    public function test_puts_cats_with_null_date_of_birth_last_when_sorting_by_age()
    {
        $this->createCat(['date_of_birth' => null]);
        $oldest = $this->createCat(['date_of_birth' => Carbon::now()->subYears(300)]);

        $oldestFirst = $this->getCatsInResponse(['age' => 'desc']);

        $this->assertEquals($oldest->id, $oldestFirst->first()->id);
    }

    public function test_id_sort_query_param_works()
    {
        /** @var Cat $first */
        $first = Cat::orderBy('id')->first();
        /** @var Cat $latest */
        $latest = Cat::orderBy('id', 'desc')->first();

        $this->assertStringNotContainsString('id', $this->getCatsInResponse()->url(1));

        $catsAsc = $this->getCatsInResponse(['id' => 'asc']);
        $catsDesc = $this->getCatsInResponse(['id' => 'desc']);

        $this->assertEquals($first->id, $catsAsc->first()->id);
        $this->assertStringContainsString('id=asc', $catsAsc->url(1));

        $this->assertEquals($latest->id, $catsDesc->first()->id);
        $this->assertStringContainsString('id=desc', $catsDesc->url(1));
    }

    public function test_search_by_name_works()
    {
        $garfield = $this->createCat(['name' => 'Garfield']);
        $arfieson = $this->createCat(['name' => 'Arfiešon']);

        $results = $this->getCatsInResponse(['search' => 'garf']);
        $this->assertTrue($results->contains('id', $garfield->id));
        $this->assertFalse($results->contains('id', $arfieson->id));
        $this->assertStringContainsString('search=garf', $results->url(1));

        $results = $this->getCatsInResponse(['search' => 'arfie']);
        $this->assertTrue($results->contains('id', $garfield->id));
        $this->assertTrue($results->contains('id', $arfieson->id));
        $this->assertStringContainsString('search=arfie', $results->url(1));

        $results = $this->getCatsInResponse(['search' => 'rfieš']);
        $this->assertFalse($results->contains('id', $garfield->id));
        $this->assertTrue($results->contains('id', $arfieson->id));
        $this->assertStringContainsString('search=rfie%C5%A1', $results->url(1));
    }

    protected function getResponse(array $params = []): TestResponse
    {
        return $this->get(route('cat_list', $params));
    }

    protected function getCatsInResponse(array $params = []): LengthAwarePaginator
    {
        return $this->getResponse($params)->getOriginalContent()->getData()['cats'];
    }
}
