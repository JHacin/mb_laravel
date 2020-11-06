<?php

namespace Tests\Utilities\TestData;

class TestCatGarfield implements TestCat
{

    /**
     * @inheritDoc
     */
    static function getName()
    {
        return 'Garfield';
    }
}
