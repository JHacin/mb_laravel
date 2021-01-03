<?php

namespace Tests\Unit\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;
use UserMail;

class RegisterControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_sends_welcome_email()
    {
        $requestMock = Mockery::mock(Request::class);
        /** @var User $userModel */
        $userModel = User::factory()->makeOne();

        $requestMock
            ->shouldReceive('all')
            ->twice()
            ->andReturn([
                'name' => $userModel->name,
                'email' => $userModel->email,
                'password' => 'asdf123456',
                'password_confirmation' => 'asdf123456',
            ]);

        UserMail::shouldReceive('sendWelcomeEmail')
            ->once()
            ->withArgs(function (User $user) use ($userModel) {
                return $user->email === $userModel->email;
            });

        $requestMock
            ->shouldReceive('wantsJson')
            ->once()
            ->andReturn(false);

        (new RegisterController())->register($requestMock);
    }
}
