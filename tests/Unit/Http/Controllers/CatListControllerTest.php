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

    /**
     * @var bool
     */
    protected bool $seed = true;

    /**
     * @return void
     */
    public function test_returns_list_of_cats()
    {
        $response = $this->getResponse();
        $response->assertViewHas('cats');
    }

    /**
     * @return void
     */
    public function test_orders_by_created_at_descending()
    {
        $lastAddedCat = $this->createCat();
        $cats = $this->getCatsInResponse();
        /** @var Cat $firstCatInList */
        $firstCatInList = $cats->first();

        $this->assertEquals($firstCatInList->id, $lastAddedCat->id);
    }

    /**
     * @return void
     */
    public function test_doesnt_show_inactive_cats()
    {
        $inactiveCat = $this->createCat(['is_active' => false]);
        $cats = $this->getCatsInResponse();

        $this->assertFalse($cats->contains($inactiveCat->id));
    }

    /**
     * @return void
     */
    public function test_returns_12_cats_per_page_by_default()
    {
        $cats = $this->getCatsInResponse();

        $this->assertEquals(Cat::PER_PAGE_DEFAULT, $cats->perPage());
    }

    /**
     * @return void
     */
    public function test_per_page_query_param_works()
    {
        foreach (Cat::PER_PAGE_OPTIONS as $option) {
            $cats = $this->getCatsInResponse(['per_page' => $option]);
            $this->assertEquals($option === 'all' ? Cat::count() : $option, $cats->perPage());
            $this->assertStringContainsString('per_page=' . $option, $cats->url(1));
        }
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function test_age_sort_query_param_works()
    {
        $oldest = $this->createCat(['date_of_birth' => Carbon::now()->subYears(300)]);
        $youngest = $this->createCat(['date_of_birth' => Carbon::now()]);
        Cat::factory()->createOne();

        $this->assertStringNotContainsString('age=asc', $this->getCatsInResponse()->url(1));
        $this->assertStringNotContainsString('age=desc', $this->getCatsInResponse()->url(1));

        $oldestFirst = $this->getCatsInResponse(['age' => 'desc']);
        $youngestFirst = $this->getCatsInResponse(['age' => 'asc']);

        $this->assertEquals($oldest->id, $oldestFirst->first()->id);
        $this->assertStringContainsString('age=desc', $oldestFirst->url(1));

        $this->assertEquals($youngest->id, $youngestFirst->first()->id);
        $this->assertStringContainsString('age=asc', $youngestFirst->url(1));
    }

    /**
     * @return void
     */
    public function test_puts_cats_with_null_date_of_birth_last_when_sorting_by_age()
    {
        $this->createCat(['date_of_birth' => null]);
        $oldest = $this->createCat(['date_of_birth' => Carbon::now()->subYears(300)]);

        $oldestFirst = $this->getCatsInResponse(['age' => 'desc']);

        $this->assertEquals($oldest->id, $oldestFirst->first()->id);
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function test_search_by_name_works()
    {
        $garfield = $this->createCat(['name' => 'Garfield']);
        $arfieson = $this->createCat(['name' => 'Arfiešon']);

        $results = $this->getCatsInResponse();
        $this->assertTrue($results->contains('id', $garfield->id));
        $this->assertTrue($results->contains('id', $arfieson->id));
        $this->assertStringNotContainsString('search', $results->url(1));

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

    /**
     * @param array $params
     * @return TestResponse
     */
    protected function getResponse(array $params = []): TestResponse
    {
        return $this->get(route('cat_list', $params));
    }

    /**
     * @param array $params
     * @return LengthAwarePaginator
     */
    protected function getCatsInResponse(array $params = []): LengthAwarePaginator
    {
        return $this->getResponse($params)->getOriginalContent()->getData()['cats'];
    }
}
