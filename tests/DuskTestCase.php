<?php

namespace Tests;

use App\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\TestCase as BaseTestCase;
use Tests\Browser\Traits\ElementTestingHelpers;
use Tests\Browser\Traits\FormTestingHelpers;
use Tests\Traits\CreatesApplication;
use Tests\Traits\CreatesMockData;

abstract class DuskTestCase extends BaseTestCase
{
    use WithFaker, CreatesApplication, CreatesMockData, FormTestingHelpers, ElementTestingHelpers;

    protected static bool $migrationRun = false;
    protected static ?User $sampleUser = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resetDatabaseBeforeFirstTest();
        $this->createSampleUser();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        foreach (static::$browsers as $browser) {
            $browser->driver->manage()->deleteAllCookies();
        }
    }

    private function resetDatabaseBeforeFirstTest()
    {
        if (!static::$migrationRun) {
            $this->artisan('migrate:fresh');
            $this->artisan('db:seed');
            static::$migrationRun = true;
        }
    }

    private function createSampleUser()
    {
        if (!static::$sampleUser) {
            static::$sampleUser = $this->createUserWithPersonData();
        }
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
            ChromeOptions::CAPABILITY, $options
        )
        );
    }
}
