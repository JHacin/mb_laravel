<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Cat;
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
        }
    }

    /**
     * @return void
     */
    public function test_sponsorship_count_query_param_works()
    {
        $this->createCatWithSponsorships([], 0);
        $this->createCatWithSponsorships([], 99);

        $catsAsc = $this->getCatsInResponse(['sponsorship_count' => 'asc']);
        $catsDesc = $this->getCatsInResponse(['sponsorship_count' => 'desc']);

        $this->assertEquals(0, $catsAsc->first()->sponsorships()->count());
        $this->assertEquals(99, $catsDesc->first()->sponsorships()->count());
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
