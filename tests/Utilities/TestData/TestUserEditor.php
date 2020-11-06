<?php

namespace Tests\Utilities\TestData;

class TestUserEditor implements TestUser
{

    /**
     * @inheritDoc
     */
    static function getEmail()
    {
        return 'test_editor@example.com';
    }

    static function getPassword()
    {
        return 'asd';
    }
}
