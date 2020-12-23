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
    public function test_returns_15_cats_per_page_by_default()
    {
        $cats = $this->getCatsInResponse();

        $this->assertEquals(15, $cats->perPage());
    }

    /**
     * @return void
     */
    public function test_per_page_query_param_works()
    {
        $options = [15, 30, Cat::count()];

        foreach ($options as $option) {
            $cats = $this->getCatsInResponse(['per_page' => $option]);
            $this->assertEquals($option, $cats->perPage());
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

        $catsAsc = $this->getCatsInResponse(['age' => 'asc']);
        $catsDesc = $this->getCatsInResponse(['age' => 'desc']);

        $this->assertEquals($youngest->id, $catsAsc->first()->id);
        $this->assertStringContainsString('age=asc', $catsAsc->url(1));

        $this->assertEquals($oldest->id, $catsDesc->first()->id);
        $this->assertStringContainsString('age=desc', $catsDesc->url(1));
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

        $catsAsc = $this->getCatsInResponse(['id' => 'asc']);
        $catsDesc = $this->getCatsInResponse(['id' => 'desc']);

        $this->assertEquals($first->id, $catsAsc->first()->id);
        $this->assertStringContainsString('id=asc', $catsAsc->url(1));

        $this->assertEquals($latest->id, $catsDesc->first()->id);
        $this->assertStringContainsString('id=desc', $catsDesc->url(1));
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
