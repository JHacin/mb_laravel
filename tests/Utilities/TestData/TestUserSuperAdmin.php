<?php

namespace Tests\Utilities\TestData;

class TestUserSuperAdmin implements TestUser
{

    /**
     * @inheritDoc
     */
    static function getEmail()
    {
        return 'test_super_admin@example.com';
    }

    static function getPassword()
    {
        return 'RJWcO3fQQi05';
    }
}
