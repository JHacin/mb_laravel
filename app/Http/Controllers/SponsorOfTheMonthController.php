<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SponsorOfTheMonthController extends Controller
{
    public function index(): View
    {
        return view('become-sponsor-of-the-month');
    }
}
