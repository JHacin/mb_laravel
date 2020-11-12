<?php

namespace Tests\Utilities\TestData;

use App\Models\Cat;

class TestCat
{
    /**
     * @var string
     */
    public $name;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->name = $attributes['name'];
    }

    /**
     * @return Cat
     */
    public function get()
    {
        return Cat::firstWhere('name', $this->name);
    }
}
