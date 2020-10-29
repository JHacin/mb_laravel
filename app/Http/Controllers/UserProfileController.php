<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function index()
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
        $data = $request->all();

        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if ($data['password']) {
            $update['password'] = Hash::make($data['password']);
        }

        $user = Auth::user();
        $user->update($update);

        return redirect()->back();
    }
}
