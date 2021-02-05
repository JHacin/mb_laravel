<?php

namespace Tests\Browser;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatSponsorshipFormPage;
use Tests\DuskTestCase;
use Throwable;

class CatSponsorshipFormTest extends DuskTestCase
{
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
                '@personData[gender]-input-wrapper',
                '@monthly_amount-input-wrapper',
                '@personData[address]-input-wrapper',
                '@personData[zip_code]-input-wrapper',
                '@personData[city]-input-wrapper',
            ]);
            $browser->assertSeeIn('@is_agreed_to_terms-input-wrapper', 'Polje mora biti obkljukano');
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
     * @throws Throwable
     */
    public function test_preserves_old_values_on_invalid_submission()
    {
        $this->browse(function (Browser $b) {
            /** @var PersonData $personData */
            $personData = PersonData::factory()->makeOne();
            $formData = $this->getPersonDataFieldValueArray($personData);

            $this->goToPage($b);
            $this->disableHtmlFormValidation($b);
            $this->fillOutAllFields($b, $formData);
            $b->uncheck('@is_agreed_to_terms-input');
            $this->submit($b);

            foreach ($formData as $name => $value) {
                $b->assertValue("@personData[$name]-input", $formData[$name]);
            }
            $b->assertValue('@monthly_amount-input', '5');
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
        $this->browse(function (Browser $b) {
            self::$cat->sponsorships()->delete();
            $b->loginAs(self::$sampleUser);
            $this->goToPage($b);
            $this->fillOutNonPersonDataFields($b);
            $b->uncheck('@wants_direct_debit-input');
            $this->submit($b);
            $b->assertSee('Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.');
            $this->assertDatabaseHas('sponsorships', [
                'person_data_id' => self::$sampleUser->personData->id,
                'cat_id' => self::$cat->id,
                'monthly_amount' => 5,
                'is_anonymous' => 1,
                'payment_type' => Sponsorship::PAYMENT_TYPE_BANK_TRANSFER,
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
                'gender' => PersonData::GENDER_FEMALE,
                'country' => 'BE',
            ]);

            /** @var PersonData $newPersonData */
            $newPersonData = PersonData::factory()->makeOne([
                'email' => 'changed_test@example.com',
                'first_name' => 'changed_first_name',
                'last_name' => 'changed_last_name',
                'gender' => PersonData::GENDER_MALE,
                'address' => 'changed_address',
                'zip_code' => 'changed_zip_code',
                'city' => 'changed_city',
                'country' => 'SE',
            ]);
            $formData = $this->getPersonDataFieldValueArray($newPersonData);

            $browser->loginAs(self::$sampleUser);
            $this->goToPage($browser);
            $this->fillOutAllFields($browser, $formData);
            $this->submit($browser);

            $this->assertDatabaseHas(
                'person_data',
                array_merge(['id' => self::$sampleUser->personData->id], $formData)
            );
        });
    }

    /**
     * @throws Throwable
     */
    public function test_handles_anon_user_submission()
    {
        $this->browse(function (Browser $b) {
            self::$cat->sponsorships()->delete();
            /** @var PersonData $personData */
            $personData = PersonData::factory()->makeOne();
            $formData = $this->getPersonDataFieldValueArray($personData);

            $this->goToPage($b);
            $this->fillOutAllFields($b, $formData);
            $this->submit($b);
            $b->assertSee('Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.');

            /** @var PersonData $createdPersonData */
            $createdPersonData = PersonData::firstWhere('email', $personData->email);
            $this->assertDatabaseHas(
                'person_data',
                array_merge(['id' => $createdPersonData->id], $formData)
            );
            $this->assertDatabaseHas('sponsorships', [
                'person_data_id' => $createdPersonData->id,
                'cat_id' => self::$cat->id,
                'monthly_amount' => 5,
                'is_anonymous' => 1,
                'payment_type' => Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT,
            ]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_prevents_duplicate_active_sponsor_emails_for_one_cat()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat();
            $personData = $this->createPersonData();
            $sponsorship = $this->createSponsorship([
                'cat_id' => $cat->id,
                'person_data_id' => $personData->id,
                'is_active' => true,
            ]);

            $this->goToPage($b, $cat);
            $formData = $this->getPersonDataFieldValueArray($personData);
            $this->fillOutAllFields($b, $formData);

            $this->submit($b);
            $b->assertSee('Muca že ima aktivnega botra s tem email naslovom.');

            $sponsorship->update(['is_active' => false]);
            $this->submit($b);
            $b->assertSee('Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.');
        });
    }

    /**
     * @param Browser $browser
     * @param Cat|null $cat
     * @return Browser
     */
    protected function goToPage(Browser $browser, Cat $cat = null): Browser
    {
        return $browser->visit(new CatSponsorshipFormPage($cat ?: self::$cat));
    }

    /**
     * @param Browser $browser
     * @param array $formData
     */
    protected function fillOutAllFields(Browser $browser, array $formData)
    {
        $this->fillOutNonPersonDataFields($browser);
        $this->fillOutPersonDataFields($browser, $formData);
    }

    /**
     * @param PersonData $personData
     * @return array
     */
    protected function getPersonDataFieldValueArray(PersonData $personData): array
    {
        return [
            'email' => $personData->email,
            'first_name' => $personData->first_name,
            'last_name' => $personData->last_name,
            'gender' => $personData->gender,
            'address' => $personData->address,
            'zip_code' => $personData->zip_code,
            'city' => $personData->city,
            'country' => $personData->country,
        ];
    }

    /**
     * @param Browser $browser
     * @param array $formData
     */
    protected function fillOutPersonDataFields(Browser $browser, array $formData)
    {
        $browser
            ->type('@personData[email]-input', $formData['email'])
            ->type('@personData[first_name]-input', $formData['first_name'])
            ->type('@personData[last_name]-input', $formData['last_name'])
            ->select('@personData[gender]-input', $formData['gender'])
            ->type('@personData[address]-input', $formData['address'])
            ->type('@personData[zip_code]-input', $formData['zip_code'])
            ->type('@personData[city]-input', $formData['city'])
            ->select('@personData[country]-input', $formData['country']);
    }

    protected function fillOutNonPersonDataFields(Browser $b)
    {
        $b->type('@monthly_amount-input', '5');
        $b->check('@is_anonymous-input');
        $b->check('@is_agreed_to_terms-input');
        $b->check('@wants_direct_debit-input');
    }

    protected function submit(Browser $b)
    {
        $b->click('@cat-sponsorship-submit');
    }
}
