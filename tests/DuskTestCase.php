<?php

namespace Tests;

use App\Models\PersonData;
use App\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Laravel\Dusk\TestCase as BaseTestCase;
use Tests\Browser\Traits\FormTestingHelpers;
use Tests\Traits\CreatesApplication;
use Tests\Traits\CreatesMockData;

abstract class DuskTestCase extends BaseTestCase
{
    use WithFaker, CreatesApplication, CreatesMockData, FormTestingHelpers;

    /**
     * @var bool
     */
    protected static bool $migrationRun = false;

    /**
     * @var User|null
     */
    protected static ?User $sampleUser = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->resetDatabaseBeforeFirstTest();
        $this->createSampleUser();
    }

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        foreach (static::$browsers as $browser) {
            $browser->driver->manage()->deleteAllCookies();
        }
    }

    /**
     * @return void
     */
    protected function resetDatabaseBeforeFirstTest()
    {
        if (!static::$migrationRun) {
            $this->artisan('migrate:fresh');
            $this->artisan('db:seed');
            static::$migrationRun = true;
        }
    }

    protected function createSampleUser()
    {
        if (!static::$sampleUser) {
            static::$sampleUser = $this->createUser();
            $fakePersonData = Arr::except(PersonData::factory()->make()->toArray(), ['id', 'email']);
            static::$sampleUser->personData->update($fakePersonData);
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

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return RemoteWebDriver
     */
    protected function driver()
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
