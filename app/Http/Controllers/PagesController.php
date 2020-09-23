<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class PagesController extends Controller
{
    /**
     * Show the homepage.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }
}
