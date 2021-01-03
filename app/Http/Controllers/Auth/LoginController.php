<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected string $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $rules = [
            $this->username() => [
                'required',
                'string',
                'max:255',
                Rule::exists('users', 'email')->where('is_active', true)
            ],
            'password' => ['required', 'string'],
        ];

        $messages = [
            'exists' => 'Uporabnik s tem e-mail naslovom ne obstaja oz. še ni aktiviran.',
        ];

        $request->validate($rules, $messages);
    }
}
