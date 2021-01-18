<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class GiftSponsorshipController extends Controller
{
    public function index(): View
    {
        return view('gift-sponsorship');
    }
}
