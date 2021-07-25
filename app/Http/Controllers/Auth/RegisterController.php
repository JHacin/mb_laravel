<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Validation\Validator as ValidatorInstance;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected string $redirectTo = RouteServiceProvider::HOME;

    private UserMail $userMail;

    public function __construct(UserMail $userMail)
    {
        $this->userMail = $userMail;
        $this->middleware('guest');
    }

    protected function validator(array $data): ValidatorInstance
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => User::generateSecurePassword($data['password']),
            'is_active' => true,
        ]);

        $this->userMail->sendWelcomeEmail($user);

        return $user;
    }
}
