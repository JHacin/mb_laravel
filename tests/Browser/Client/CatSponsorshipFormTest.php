<?php

namespace Tests\Browser\Client;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use Laravel\Dusk\Browser;
use Tests\Browser\Client\Pages\CatSponsorshipFormPage;
use Tests\DuskTestCase;
use Throwable;

class CatSponsorshipFormTest extends DuskTestCase
{
    /**
     * @throws Throwable
     */
    public function test_throws_403_if_the_cat_does_not_have_seeking_sponsors_status()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat(['status' => Cat::STATUS_SEEKING_SPONSORS]);

            $this->goToPage($b, $cat);
            $b->assertSee('Dogovor o posvojitvi na daljavo');
            $b->assertDontSee('Prepovedan dostop');

            // Cat updated while form was open
            $cat->update(['status' => Cat::STATUS_TEMP_NOT_SEEKING_SPONSORS]);
            /** @var PersonData $personData */
            $personData = PersonData::factory()->makeOne();
            $this->fillOutAllFields($b, $this->getPersonDataFieldValueArray($personData));
            $this->submit($b);
            $b->assertDontSee('Dogovor o posvojitvi na daljavo');
            $b->assertSee('Prepovedan dostop');

            // Going to the page after cat was updated
            $this->goToPage($b, $cat);
            $b->assertDontSee('Dogovor o posvojitvi na daljavo');
            $b->assertSee('Prepovedan dostop');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_association_to_correct_cat()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat();

            $associationText = sprintf(
                'Ime živali, ki jo želite posvojiti na daljavo: %s (%s)',
                $cat->name,
                $cat->id
            );

            $this
                ->goToPage($b, $cat)
                ->assertSee($associationText);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, $this->createCat());
            $this->disableHtmlFormValidation($b);
            $this->submit($b);
            $this->assertAllRequiredErrorsAreShown($b, [
                '@personData[first_name]-input-wrapper',
                '@personData[last_name]-input-wrapper',
                '@personData[email]-input-wrapper',
                '@personData[gender]-input-wrapper',
                '@monthly_amount-input-wrapper',
                '@personData[address]-input-wrapper',
                '@personData[zip_code]-input-wrapper',
                '@personData[city]-input-wrapper',
            ]);
            $b->assertSeeIn('@is_agreed_to_terms-input-wrapper', 'Polje mora biti obkljukano');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_email_field()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, $this->createCat());
            $this->disableHtmlFormValidation($b);
            $b->type('@personData[email]-input', 'aasdasasdsa');
            $this->submit($b);
            $b->assertSee(trans('validation.email'));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_amount_field()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, $this->createCat());

            $this->disableHtmlFormValidation($b);
            $b->type('@monthly_amount-input', '-1');
            $this->submit($b);
            $b->assertSee('Minimalni mesečni znesek je 5€.');

            $this->disableHtmlFormValidation($b);
            $b->type('@monthly_amount-input', '999999999999');
            $this->submit($b);
            $b->assertSee('Vrednost ne sme biti večja od 999999.99.');

            $this->disableHtmlFormValidation($b);
            $b->script("document.getElementById('monthly_amount').setAttribute('type', 'text')");
            $b->type('@monthly_amount-input', 'asdsadsadad');
            $this->submit($b);
            $b->assertSee('Vrednost mora biti številka.');
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

            $this->goToPage($b, $this->createCat());
            $this->disableHtmlFormValidation($b);
            $this->fillOutAllFields($b, $formData);
            $b->uncheck('@is_agreed_to_terms-input');
            $this->submit($b);

            foreach ($formData as $name => $value) {
                $b->assertValue("@personData[$name]-input", $value);
            }
            $b->assertValue('@monthly_amount-input', '5');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_handles_submission()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat();
            $cat->sponsorships()->delete();
            /** @var PersonData $personData */
            $personData = PersonData::factory()->makeOne();
            $formData = $this->getPersonDataFieldValueArray($personData);

            $this->goToPage($b, $cat);
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
                'sponsor_id' => $createdPersonData->id,
                'cat_id' => $cat->id,
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
                'sponsor_id' => $personData->id,
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

    protected function goToPage(Browser $b, Cat $cat): Browser
    {
        return $b->visit(new CatSponsorshipFormPage($cat));
    }

    protected function fillOutAllFields(Browser $b, array $formData)
    {
        $this->fillOutNonPersonDataFields($b);
        $this->fillOutPersonDataFields($b, $formData);
    }

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

    protected function fillOutPersonDataFields(Browser $b, array $formData)
    {
        $b
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
