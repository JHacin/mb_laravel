<?php

namespace Tests\Utilities\TestData;

class TestUserAdmin implements TestUser
{

    /**
     * @inheritDoc
     */
    static function getEmail()
    {
        return 'test_admin@example.com';
    }

    static function getPassword()
    {
        return 'asd';
    }
}
