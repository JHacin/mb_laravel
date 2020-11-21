<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\CreatesApplication;
use Tests\Traits\CreatesMockData;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, CreatesMockData;
}
