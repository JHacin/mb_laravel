<?php

namespace Tests\Browser\Client;

use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\Browser\Client\Pages\HomePage;
use Tests\Browser\Client\Pages\LoginPage;
use Tests\Browser\Client\Pages\UserProfilePage;
use Tests\DuskTestCase;
use Throwable;

class UserProfileTest extends DuskTestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_redirects_guest_to_login()
    {
        $this->browse(function (Browser $b) {
            $b->visit((new UserProfilePage())->url());
            $b->on(new LoginPage);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_no_sponsorships_message_if_none_exist()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, $this->createUser());

            $b->with('@sponsorship-list', function (Browser $b) {
                $b->assertSee('Nimate še botrstev.');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_sponsorship_list_if_sponsorships_exist()
    {
        $this->browse(function (Browser $b) {
            $user = $this->createUserWithSponsorships();
            $sponsorships = $user->personData->sponsorships;

            $this->goToPage($b, $user);

            $b->with('@sponsorship-list', function (Browser $b) use ($sponsorships) {
                $sponsorships->each(function (Sponsorship $sponsorship) use ($b) {
                    $b->assertSee($sponsorship->cat->name);
                });
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_user_data()
    {
        $this->browse(function (Browser $b) {
            $user = $this->createUserWithPersonData();
            $this->goToPage($b, $user);

            $b->assertInputValue('name', $user->name);
            $b->assertInputValue('email', $user->email);
            $b->assertInputValue('password', '');
            $b->assertInputValue('password_confirmation', '');
            $b->assertInputValue('personData[first_name]', $user->personData->first_name);
            $b->assertInputValue('personData[last_name]', $user->personData->last_name);
            $b->assertSelected('personData[gender]', $user->personData->gender);
            $b->assertInputValue('personData[date_of_birth]', $user->personData->date_of_birth->toDateString());
            $b->assertInputValue('personData[address]', $user->personData->address);
            $b->assertInputValue('personData[zip_code]', $user->personData->zip_code);
            $b->assertInputValue('personData[city]', $user->personData->city);
            $b->assertSelected('personData[country]', $user->personData->country);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, $this->createUser());
            $this->disableHtmlFormValidation($b);
            $b->clear('name');
            $b->clear('email');
            $this->submit($b);
            $this->assertAllRequiredErrorsAreShown(
                $b,
                ['@name-input-wrapper', '@email-input-wrapper', '@personData[gender]-input-wrapper']
            );
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_max_length()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, $this->createUser());
            $this->disableHtmlFormValidation($b);

            $fields = [
                'name',
                'email',
                'password',
                'personData[first_name]',
                'personData[last_name]',
                'personData[address]',
                'personData[zip_code]',
                'personData[city]',
            ];

            foreach ($fields as $field) {
                $b->type($field, Str::random(256));
            }

            $this->submit($b);

            foreach ($fields as $field) {
                $b->assertSeeIn(
                    '@' . $field . '-input-wrapper',
                    'Polje ne sme imeti več kot 255 znakov.'
                );
            }
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_email()
    {
        $this->browse(function (Browser $b) {
            $user = $this->createUser();

            // Format
            $this->goToPage($b, $user);
            $this->disableHtmlFormValidation($b);
            $b->type('email', 'fdfdfdf');
            $this->submit($b);
            $b->assertSeeIn('@email-input-wrapper', 'Vrednost mora biti veljaven email naslov.');

            // Unique
            $otherUser = $this->createUser();
            $this->goToPage($b, $user);
            $this->disableHtmlFormValidation($b);
            $b->type('email', $otherUser->email);
            $this->submit($b);
            $b->assertSeeIn('@email-input-wrapper', 'Ta email naslov je že v uporabi.');

            // Success
            $this->goToPage($b, $user);
            $this->fillOutRequiredFields($b);
            $this->submit($b);
            $b->assertSee('Vaši podatki so bili posodobljeni.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_password()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, $this->createUser());

            // Min length
            $this->disableHtmlFormValidation($b);
            $b->type('password', 'xx');
            $b->type('password_confirmation', 'xx');
            $this->submit($b);
            $b->assertSeeIn('@password-input-wrapper', 'Geslo mora biti dolgo vsaj 8 znakov.');

            // Confirmed
            $this->disableHtmlFormValidation($b);
            $b->type('password', 'xxxxxxxxxxxxxxxx');
            $b->type('password_confirmation', 'xxyyyyyyyyyyy');
            $this->submit($b);
            $b->assertSeeIn('@password-input-wrapper', 'Gesli se ne ujemata.');

            // Success
            $this->fillOutRequiredFields($b);
            $b->type('password', 'xxxxxxxxxxxxxxxx');
            $b->type('password_confirmation', 'xxxxxxxxxxxxxxxx');
            $this->submit($b);
            $b->assertSee('Vaši podatki so bili posodobljeni.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_gender()
    {
        $this->browse(function (Browser $b) {
            // Valid value
            $this->goToPage($b, $this->createUser());
            $this->fillOutRequiredFields($b);
            $this->selectInvalidSelectOption($b, 'personData[gender]');
            $this->submit($b);
            $b->assertSeeIn('@personData[gender]-input-wrapper', 'Izbrana vrednost ni veljavna.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_date_of_birth()
    {
        $this->browse(function (Browser $b) {
            // Before now
            $this->goToPage($b, $this->createUser());
            $this->fillOutRequiredFields($b);
            $this->setHiddenInputValue($b, 'personData[date_of_birth]', Carbon::now()->addDay()->toDateString());
            $this->submit($b);
            $b->assertSeeIn('@personData[date_of_birth]-input-wrapper', 'Datum rojstva mora biti v preteklosti.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_country()
    {
        $this->browse(function (Browser $b) {
            // Valid value
            $this->goToPage($b, $this->createUser());
            $this->fillOutRequiredFields($b);
            $this->selectInvalidSelectOption($b, 'personData[country]');
            $this->submit($b);
            $b->assertSeeIn('@personData[country]-input-wrapper', 'Vrednost mora biti država.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_updates_password()
    {
        $this->browse(function (Browser $b) {
            $user = $this->createUser();
            $newPassword = 'xxxxxxxxxxxxxxxx';

            // Change pw
            $this->goToPage($b, $user);
            $this->fillOutRequiredFields($b);
            $b->type('password', $newPassword);
            $b->type('password_confirmation', $newPassword);
            $this->submit($b);

            $b->logout();

            // Try to login using new pw
            $b->visit(new LoginPage);
            $b->type('email', $user->email);
            $b->type('password', $newPassword);
            $b->click('@login-form-submit');
            $b->on(new HomePage);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_updates_attributes()
    {
        $this->browse(function (Browser $b) {
            $user = $this->createUserWithPersonData(
                [],
                [
                    'gender' => PersonData::GENDER_MALE,
                    'country' => 'AI'
                ]
            );
            /** @var User $newUserData */
            $newUserData = User::factory()->makeOne();
            /** @var PersonData $newPersonData */
            $newPersonData = PersonData::factory()->makeOne(
                [
                    'gender' => PersonData::GENDER_FEMALE,
                    'country' => 'US'
                ]
            );
            $this->goToPage($b, $user);

            $b->type('name', $newUserData->name);
            $b->type('email', $newUserData->email);
            $b->type('personData[first_name]', $newPersonData->first_name);
            $b->type('personData[last_name]', $newPersonData->last_name);
            $b->select('personData[gender]', $newPersonData->gender);
            $this->selectFlatpickrDateInThePast($b, '@personData[date_of_birth]-input-wrapper');
            $b->type('personData[address]', $newPersonData->address);
            $b->type('personData[zip_code]', $newPersonData->zip_code);
            $b->type('personData[city]', $newPersonData->city);
            $b->select('personData[country]', $newPersonData->country);
            $dateOfBirthInputValue = $b->inputValue('personData[date_of_birth]');

            $this->submit($b);
            $b->assertSee('Vaši podatki so bili posodobljeni.');
            $this->assertDatabaseHas('users', [
                'id' => $user->id,
                'name' => $newUserData->name,
                'email' => $newUserData->email,
            ]);
            $this->assertDatabaseHas('person_data', [
                'id' => $user->personData->id,
                'first_name' => $newPersonData->first_name,
                'gender' => $newPersonData->gender,
                'date_of_birth' => $dateOfBirthInputValue,
                'address' => $newPersonData->address,
                'zip_code' => $newPersonData->zip_code,
                'city' => $newPersonData->city,
                'country' => $newPersonData->country,
            ]);
        });
    }

    protected function fillOutRequiredFields(Browser $b) {
        $b->select('personData[gender]', PersonData::GENDER_FEMALE);
    }

    /**
     * @param Browser $b
     * @param User $user
     */
    protected function goToPage(Browser $b, User $user)
    {
        $b->loginAs($user);
        $b->visit(new UserProfilePage);
    }

    /**
     * @param Browser $b
     */
    protected function submit(Browser $b)
    {
        $b->click('@user-profile-form-submit');
    }
}
