<?php

namespace Tests\Utilities\TestData;

class TestUserAuthenticated implements TestUser
{
    /**
     * @inheritDoc
     */
    static function getEmail()
    {
        return 'test_authenticated@example.com';
    }

    static function getPassword()
    {
        return 'asd';
    }
}
