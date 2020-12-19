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
        $response = $this->getResponse();
        $cats = $this->getCatsInResponse($response);

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
        $response = $this->getResponse();
        $cats = $this->getCatsInResponse($response);

        $this->assertFalse($cats->contains($inactiveCat->id));
    }

    /**
     * @return void
     */
    public function test_returns_25_cats_per_page_by_default()
    {
        Cat::factory()->count(100)->create();

        $response = $this->getResponse();
        $cats = $this->getCatsInResponse($response);

        $this->assertCount(25, $cats);
    }

    /**
     * @return TestResponse
     */
    protected function getResponse(): TestResponse
    {
        return $this->get(config('routes.cat_list'));
    }

    /**
     * @param TestResponse $response
     * @return LengthAwarePaginator
     */
    protected function getCatsInResponse(TestResponse $response): LengthAwarePaginator
    {
        return $response->getOriginalContent()->getData()['cats'];
    }
}
