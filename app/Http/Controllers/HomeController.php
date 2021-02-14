<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $heroCats = Cat::has('photos')
            ->whereNotNull('date_of_arrival_mh')
            ->where('is_group', false)
            ->inRandomOrder()
            ->get()
            ->slice(0, 3);

        return view('home', ['heroCats' => $heroCats]);
    }
}
