<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

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
}
