<?php

namespace Tests\Unit\Http\Controllers\Admin\PermissionManager;

use App\Models\PersonData;
use Tests\TestCase;
use UserMail;

class UserCrudControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_welcome_email_if_needed()
    {
        UserMail::shouldReceive('sendWelcomeEmail')->once();

        $this->actingAs($this->createSuperAdminUser())->post('admin/uporabniki', [
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->unique()->company,
            'password' => 'abcd1234',
            'password_confirmation' => 'abcd1234',
            'personData.gender' => PersonData::GENDER_FEMALE,
            'is_active' => true,
            'should_send_welcome_email' => true,
        ]);

        /** @noinspection PhpUndefinedMethodInspection */
        UserMail::shouldNotReceive('sendWelcomeEmail');

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
