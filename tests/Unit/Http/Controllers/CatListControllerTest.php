<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Cat;
use Tests\TestCase;

class CatListControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_returns_list_of_cats()
    {
        $response = $this->get(config('routes.cat_list'));

        $response->assertViewHas('cats', Cat::withCount('sponsorships')->get());
    }
}
