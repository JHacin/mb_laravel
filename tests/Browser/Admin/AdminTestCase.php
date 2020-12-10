<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Tests\Browser\Admin\Traits\CrudFilterTestingHelpers;
use Tests\Browser\Admin\Traits\CrudFormTestingHelpers;
use Tests\Browser\Admin\Traits\CrudTableTestingHelpers;
use Tests\Browser\Admin\Traits\RequestTestingHelpers;
use Tests\DuskTestCase;

class AdminTestCase extends DuskTestCase
{
    use RequestTestingHelpers, CrudTableTestingHelpers, CrudFormTestingHelpers, CrudFilterTestingHelpers;

    /**
     * @var User|null
     */
    protected static ?User $defaultAdmin = null;

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
