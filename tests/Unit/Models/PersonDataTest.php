<?php

namespace Tests\Unit\Models;


use App\Models\PersonData;
use App\Models\User;
use Tests\TestCase;

class PersonDataTest extends TestCase
{
    protected $personData;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->personData = $this->createPersonData();
    }

    /**
     * @return void
     */
    public function test_returns_whether_it_belongs_to_registered_user()
    {
        $this->personData->user()->dissociate();
        $this->assertFalse($this->personData->belongsToRegisteredUser());

        $this->personData->user()->associate(User::factory()->createOne());
        $this->assertTrue($this->personData->belongsToRegisteredUser());
    }

    /**
     * @return void
     */
    public function test_returns_gender_label()
    {
        $this->personData->update(['gender' => PersonData::GENDER_MALE]);
        $this->assertEquals('Moški', $this->personData->gender_label);
    }

    /**
     * @return void
     */
    public function test_returns_email_and_user_id_attribute_correcly()
    {
        $email = $this->personData->email;
        $this->personData->user()->associate(User::factory()->createOne());
        $userId = $this->personData->user_id;

        $this->assertEquals("$email ($userId)", $this->personData->email_and_user_id);
        $this->personData->user()->dissociate();
        $this->assertEquals("$email (ni registriran)", $this->personData->email_and_user_id);
    }
}
