<?php

namespace Tests\Utilities\TestData;

class TestPersonDataUnauthenticated implements TestPersonData
{

    /**
     * @inheritDoc
     */
    static function getEmail()
    {
        return 'test_unauthenticated@example.com';
    }
}
