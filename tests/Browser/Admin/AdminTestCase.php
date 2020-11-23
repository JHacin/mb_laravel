<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Tests\DuskTestCase;
use Tests\Browser\Traits\CrudTableTestingHelpers;
use Tests\Browser\Traits\RequestTestingHelpers;

class AdminTestCase extends DuskTestCase
{
    use RequestTestingHelpers, CrudTableTestingHelpers;

    /**
     * @var User
     */
    protected static $defaultAdmin;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->createDefaultAdmin();
    }

    /**
     * @return void
     */
    protected function createDefaultAdmin()
    {
        if (!static::$defaultAdmin) {
            static::$defaultAdmin = $this->createAdminUser();
        }
    }
}
