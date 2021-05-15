<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SpecialSponsorshipsController extends Controller
{
    public function index(): View
    {
        return view('special-sponsorships');
    }
}
