<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\CreatesApplication;
use Tests\Traits\CreatesMockData;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, CreatesMockData, WithFaker;
}
