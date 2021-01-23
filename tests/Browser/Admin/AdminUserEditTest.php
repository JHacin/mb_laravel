<?php

namespace Tests\Browser\Admin;

use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminUserEditPage;
use Tests\Browser\Pages\Admin\AdminUserListPage;
use Throwable;

class AdminUserEditTest extends AdminTestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

//    /**
//     * @var User|null
//     */
//    protected static ?User $testUser = null;
//
//    /**
//     * @inheritDoc
//     */
//    protected function setUp(): void
//    {
//        parent::setUp();
//
//        if (!static::$testUser) {
//            static::$testUser = $this->createUserWithPersonData();
//            static::$testUser->assignRole(User::ROLE_EDITOR);
//        }
//    }


    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_user_details()
    {
        $this->browse(function (Browser $browser) {
            $user = static::$testUser;
            $this->goToPage($browser);

            $browser
                ->assertValue('input[name="name"]', $user->name)
                ->assertValue('input[name="email"]', $user->email)
                ->assertValue('input[name="password"]', '')
                ->assertValue('input[name="password_confirmation"]', '')
                ->assertValue('input[name="roles[]"]', '3')
                ->assertValue('input[name="personData[first_name]"]', $user->personData->first_name)
                ->assertValue('input[name="personData[last_name]"]', $user->personData->last_name)
                ->assertValue('input[name="personData[gender]"]', $user->personData->gender)
                ->assertValue('input[name="personData[date_of_birth]"]', $user->personData->date_of_birth->toDateString())
                ->assertValue('input[name="personData[address]"]', $user->personData->address)
                ->assertValue('input[name="personData[zip_code]"]', $user->personData->zip_code)
                ->assertValue('input[name="personData[city]"]', $user->personData->city)
                ->assertSelected('personData[country]', $user->personData->country)
                ->assertValue('input[name="is_active"', $user->is_active);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_email()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->type('email', 'sdfdsfds');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Vrednost mora biti veljaven email naslov.');

            $this->goToPage($browser);
            $browser->type('email', static::$sampleUser->email);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Ta email naslov je že v uporabi.');

            $this->goToPage($browser);
            $browser->type('email', $this->faker->unique()->safeEmail);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Urejanje uspešno.');

            $this->goToPage($browser);
            $browser->type('email', static::$testUser->email);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Urejanje uspešno.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_password()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $browser->type('password', 'a');
            $browser->type('password_confirmation', 'b');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Gesli se ne ujemata.');

            $this->goToPage($browser);
            $browser->type('password', 'a');
            $browser->type('password_confirmation', 'a');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Urejanje uspešno.');
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
            ->visit(new AdminUserListPage)
            ->visit(new AdminUserEditPage(static::$testUser));

        $this->waitForRequestsToFinish($browser);
    }
}
