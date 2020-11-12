<?php

namespace Tests\Utilities\TestData;

class TestCatGarfield extends TestCat
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Garfield'
        ]);
    }
}
