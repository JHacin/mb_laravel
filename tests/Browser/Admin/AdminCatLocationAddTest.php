<?php

namespace Tests\Browser;

use App\Utilities\CountryList;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\AdminTestCase;
use Tests\Browser\Pages\Admin\AdminCatLocationAddPage;
use Tests\Browser\Pages\Admin\AdminCatLocationListPage;
use Throwable;

class AdminCatLocationAddTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->click('@crud-form-submit-button');
            $this->assertAllRequiredErrorsAreShown($browser, ['@name-wrapper']);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_adding_works()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);

            $data = [
                'name' => $this->faker->unique()->company,
                'address' => $this->faker->unique()->streetAddress,
                'zip_code' => $this->faker->unique()->postcode,
                'city' => $this->faker->unique()->city,
                'country' => array_rand(CountryList::COUNTRY_NAMES),
            ];

            $browser
                ->type('name', $data['name'])
                ->type('address', $data['address'])
                ->type('zip_code', $data['zip_code'])
                ->type('city', $data['city'])
                ->select('country', $data['country']);

            $browser
                ->click('@crud-form-submit-button')
                ->on(new AdminCatLocationListPage);

            $this->waitForRequestsToFinish($browser);

            $browser->assertSee('Vnos uspešen.');

            $browser->with(
                $this->getTableRowSelectorForIndex(1),
                function (Browser $browser) use ($data) {
                    $browser
                        ->assertSee($data['name'])
                        ->assertSee($data['address'])
                        ->assertSee($data['zip_code'])
                        ->assertSee($data['city'])
                        ->assertSee(CountryList::COUNTRY_NAMES[$data['country']]);
                }
            );
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminCatLocationListPage)
            ->click('@crud-create-button')
            ->on(new AdminCatLocationAddPage);

        $this->waitForRequestsToFinish($browser);
    }
}
