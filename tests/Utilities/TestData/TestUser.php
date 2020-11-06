<?php

namespace Tests\Utilities\TestData;

interface TestUser
{
    /**
     * @return string
     */
    static function getEmail();

    /**
     * @return string
     */
    static function getPassword();
}
