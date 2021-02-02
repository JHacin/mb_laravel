<?php

namespace Tests\Unit\Models;

use App\Models\PersonData;
use Tests\TestCase;

class PersonDataTest extends TestCase
{
    protected PersonData $personData;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->personData = $this->createPersonData();
    }

    public function test_returns_gender_label()
    {
        $this->personData->update(['gender' => PersonData::GENDER_MALE]);
        $this->assertEquals('Moški', $this->personData->gender_label);
    }

    public function test_returns_email_and_id_attribute_correcly()
    {
        $email = $this->personData->email;
        $id = $this->personData->id;

        $this->assertEquals("$email ($id)", $this->personData->email_and_id);
    }
}
