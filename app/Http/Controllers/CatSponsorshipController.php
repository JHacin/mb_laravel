<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatSponsorshipController extends Controller
{
    /**
     * Show the page with the form for sponsoring a cat.
     *
     * @param Cat $cat
     * @return Application|Factory|View|void
     */
    public function form(Cat $cat)
    {
        return view('become_cat_sponsor', ['cat' => $cat]);
    }

    public function submit(Request $request)
    {

    }
}
