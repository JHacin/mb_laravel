<?php

namespace Tests\Browser;

use App\Models\Cat;
use App\Models\PersonData;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatSponsorshipFormPage;
use Tests\DuskTestCase;
use Throwable;

class CatSponsorshipFormTest extends DuskTestCase
{
    /**
     * @var Cat|null
     */
    protected static ?Cat $cat = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        if (!static::$cat) {
            static::$cat = $this->createCat();
        }
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_association_to_correct_cat()
    {
        $this->browse(function (Browser $browser) {
            $associationText = sprintf(
                'Ime živali, ki jo želite posvojiti na daljavo: %s (%s)',
                self::$cat->name,
                self::$cat->id
            );

            $this
                ->goToPage($browser)
                ->assertSee($associationText);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_warning_to_logged_in_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(self::$sampleUser);
            $this
                ->goToPage($browser)
                ->assertSee('Pozor: vse spremembe osebnih podatkov bodo shranjene v vašem profilu.');

            $browser->logout();
            $this
                ->goToPage($browser)
                ->assertDontSee('Pozor: vse spremembe osebnih podatkov bodo shranjene v vašem profilu.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $this->submit($browser);
            $this->assertAllRequiredErrorsAreShown($browser, [
                '@personData[email]-input-wrapper',
                '@monthly_amount-input-wrapper',
                '@personData[address]-input-wrapper',
                '@personData[zip_code]-input-wrapper',
                '@personData[city]-input-wrapper',
            ]);
            $this->assertErrorIsShownWithin($browser, '@is_agreed_to_terms-input-wrapper',
                'Polje mora biti obkljukano');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_email_field()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->type('@personData[email]-input', 'aasdasasdsa');
            $this->submit($browser);
            $browser->assertSee(trans('validation.email'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_prevents_anon_from_using_existing_user_email()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->type('@personData[email]-input', self::$sampleUser->email);
            $this->submit($browser);
            $browser->assertSee('Ta email naslov že uporablja registriran uporabnik.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_allows_registered_user_to_submit_with_own_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(self::$sampleUser);
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->type('@personData[email]-input', self::$sampleUser->email);
            $this->submit($browser);
            $browser->assertDontSee('Ta email naslov že uporablja registriran uporabnik.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_amount_field()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);

            $this->disableHtmlFormValidation($browser);
            $browser->type('@monthly_amount-input', '-1');
            $this->submit($browser);
            $browser->assertSee('Minimalni mesečni znesek je 5€.');

            $this->disableHtmlFormValidation($browser);
            $browser->type('@monthly_amount-input', '999999999999');
            $this->submit($browser);
            $browser->assertSee('Vrednost ne sme biti večja od 999999.99.');

            $this->disableHtmlFormValidation($browser);
            $browser->script("document.getElementById('monthly_amount').setAttribute('type', 'text')");
            $browser->type('@monthly_amount-input', 'asdsadsadad');
            $this->submit($browser);
            $browser->assertSee('Vrednost mora biti številka.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_has_default_values_from_registered_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(self::$sampleUser);
            $this->goToPage($browser);
            $browser->assertValue('@monthly_amount-input', '');
            $browser->assertNotChecked('@is_anonymous-input');
            $browser->assertNotChecked('@is_agreed_to_terms-input');
            $browser
                ->assertValue('@personData[email]-input', self::$sampleUser->personData->email)
                ->assertValue('@personData[first_name]-input', self::$sampleUser->personData->first_name)
                ->assertValue('@personData[last_name]-input', self::$sampleUser->personData->last_name)
                ->assertValue('@personData[gender]-input', self::$sampleUser->personData->gender)
                ->assertValue('@personData[address]-input', self::$sampleUser->personData->address)
                ->assertValue('@personData[zip_code]-input', self::$sampleUser->personData->zip_code)
                ->assertValue('@personData[city]-input', self::$sampleUser->personData->city)
                ->assertValue('@personData[country]-input', self::$sampleUser->personData->country);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_handles_registered_user_submission()
    {
        $this->browse(function (Browser $browser) {
            self::$cat->sponsorships()->delete();
            $browser->loginAs(self::$sampleUser);
            $this->goToPage($browser);
            $this->fillOutNonPersonDataFields($browser);
            $this->submit($browser);
            $browser->assertSee('Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.');
            $this->assertDatabaseHas('sponsorships', [
                'person_data_id' => self::$sampleUser->personData->id,
                'cat_id' => self::$cat->id,
                'monthly_amount' => 5,
                'is_anonymous' => 1,
            ]);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_updates_registered_user_email()
    {
        $this->browse(function (Browser $browser) {
            $newEmail = $this->faker->unique()->safeEmail;
            $browser->loginAs(self::$sampleUser);
            $this->goToPage($browser);
            $this->fillOutNonPersonDataFields($browser);
            $browser->type('@personData[email]-input', $newEmail);
            $this->submit($browser);
            $browser->assertSee('Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.');
            $this->assertDatabaseHas('users', [
                'id' => self::$sampleUser->id,
                'email' => $newEmail,
            ]);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_updates_registered_user_person_data()
    {
        $this->browse(function (Browser $browser) {
            self::$sampleUser->personData()->update([
                'gender' => PersonData::GENDER_UNKNOWN,
                'country' => 'BE',
            ]);
            $browser->loginAs(self::$sampleUser);
            $this->goToPage($browser);
            $this->fillOutNonPersonDataFields($browser);

            $newData = [
                'email' => 'changed_test@example.com',
                'first_name' => 'changed_first_name',
                'last_name' => 'changed_last_name',
                'gender' => PersonData::GENDER_MALE,
                'address' => 'changed_address',
                'zip_code' => 'changed_zip_code',
                'city' => 'changed_city',
                'country' => 'SE',
            ];

            $browser
                ->type('@personData[email]-input', $newData['email'])
                ->type('@personData[first_name]-input', $newData['first_name'])
                ->type('@personData[last_name]-input', $newData['last_name'])
                ->select('@personData[gender]-input', $newData['gender'])
                ->type('@personData[address]-input', $newData['address'])
                ->type('@personData[zip_code]-input', $newData['zip_code'])
                ->type('@personData[city]-input', $newData['city'])
                ->select('@personData[country]-input', $newData['country']);

            $this->submit($browser);

            $this->assertDatabaseHas(
                'person_data',
                array_merge($newData, ['id' => self::$sampleUser->personData->id])
            );
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_handles_anon_user_submission()
    {
        $this->browse(function (Browser $browser) {
            self::$cat->sponsorships()->delete();
            $this->goToPage($browser);
            $this->fillOutNonPersonDataFields($browser);

            $data = [
                'email' => 'new_anon@example.com',
                'first_name' => 'new_anon_first_name',
                'last_name' => 'new_anon_last_name',
                'gender' => PersonData::GENDER_MALE,
                'address' => 'new_anon_address',
                'zip_code' => 'new_anon_zip_code',
                'city' => 'new_anon_city',
                'country' => 'SE',
            ];

            $browser
                ->type('@personData[email]-input', $data['email'])
                ->type('@personData[first_name]-input', $data['first_name'])
                ->type('@personData[last_name]-input', $data['last_name'])
                ->select('@personData[gender]-input', $data['gender'])
                ->type('@personData[address]-input', $data['address'])
                ->type('@personData[zip_code]-input', $data['zip_code'])
                ->type('@personData[city]-input', $data['city'])
                ->select('@personData[country]-input', $data['country']);

            $this->submit($browser);
            $browser->assertSee('Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.');

            /** @var PersonData $personDataId */
            $personDataId = PersonData::firstWhere('email', $data['email'])->id;

            $this->assertDatabaseHas(
                'person_data',
                array_merge($data, ['id' => $personDataId])
            );

            $this->assertDatabaseHas('sponsorships', [
                'person_data_id' => $personDataId,
                'cat_id' => self::$cat->id,
                'monthly_amount' => 5,
                'is_anonymous' => 1,
            ]);
        });
    }

    /**
     * @param Browser $browser
     * @return Browser
     */
    protected function goToPage(Browser $browser)
    {
        return $browser->visit(new CatSponsorshipFormPage(self::$cat));
    }

    /**
     * @param Browser $browser
     * @return Browser
     */
    protected function fillOutNonPersonDataFields(Browser $browser)
    {
        return $browser
            ->type('@monthly_amount-input', '5')
            ->check('@is_anonymous-input')
            ->check('@is_agreed_to_terms-input');
    }

    protected function submit(Browser $browser)
    {
        return $browser->click('@cat-sponsorship-submit');
    }
}
