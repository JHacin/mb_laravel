<?php

namespace Tests\Unit\Http\Controllers\Admin\PermissionManager;

use App\Mail\UserMail;
use App\Models\PersonData;
use Tests\TestCase;

class UserCrudControllerTest extends TestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

    public function test_sends_welcome_email_if_needed()
    {
        $userMailMock = $this->mock(UserMail::class);

        $userMailMock->shouldReceive('sendWelcomeEmail')->once();

        $this->actingAs($this->createSuperAdminUser())->post('admin/uporabniki', [
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->unique()->company,
            'password' => 'abcd1234',
            'password_confirmation' => 'abcd1234',
            'personData.gender' => PersonData::GENDER_FEMALE,
            'is_active' => true,
            'should_send_welcome_email' => true,
        ]);

        $userMailMock->shouldNotReceive('sendWelcomeEmail');

        $this->actingAs($this->createSuperAdminUser())->post('admin/uporabniki', [
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->unique()->company,
            'password' => 'abcd1234',
            'password_confirmation' => 'abcd1234',
            'personData.gender' => PersonData::GENDER_FEMALE,
            'is_active' => true,
            'should_send_welcome_email' => false,
        ]);
    }
}
