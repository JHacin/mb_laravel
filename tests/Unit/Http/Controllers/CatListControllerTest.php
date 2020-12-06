<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Cat;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CatListControllerTest extends TestCase
{
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
        $catCollection = $this->getCatCollectionVariable($response);

        /** @var Cat $firstCatInList */
        $firstCatInList = $catCollection->first();
        $this->assertEquals($firstCatInList->id, $lastAddedCat->id);
    }

    /**
     * @return void
     */
    public function test_doesnt_show_inactive_cats()
    {
        $inactiveCat = $this->createCat(['is_active' => false]);
        $response = $this->getResponse();
        $catCollection = $this->getCatCollectionVariable($response);

        $this->assertFalse($catCollection->contains($inactiveCat->id));
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
     * @return Collection
     */
    protected function getCatCollectionVariable(TestResponse $response): Collection
    {
        return $response->getOriginalContent()->getData()['cats'];
    }
}
