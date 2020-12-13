<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * UserProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the homepage.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('user-profile.index');
    }

    /**
     * Update the user.
     *
     * @param UserUpdateRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UserUpdateRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();

        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if ($data['password']) {
            $update['password'] = User::generateSecurePassword($data['password']);
        }

        $user->update($update);
        $user->personData()->update(
            array_merge(
                $data['personData'],
                ['email' => $data['email']]
            )
        );

        return back()->with(
            'success_message',
            'Vaši podatki so bili posodobljeni.'
        );
    }
}
