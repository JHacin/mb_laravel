<?php

namespace Tests\Unit\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\Mail\UserMail;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

    /**
     * @throws BindingResolutionException
     */
    public function test_sends_welcome_email()
    {
        $userMailMock = $this->mock(UserMail::class);
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

        $userMailMock
            ->shouldReceive('sendWelcomeEmail')
            ->once()
            ->withArgs(function (User $user) use ($userModel) {
                return $user->email === $userModel->email;
            });

        $requestMock
            ->shouldReceive('wantsJson')
            ->once()
            ->andReturn(false);

        $ctrl = $this->app->make(RegisterController::class);
        $ctrl->register($requestMock);
    }
}
