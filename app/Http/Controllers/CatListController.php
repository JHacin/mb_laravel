<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CatListController extends Controller
{
    /**
     * Show the cat list.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $cats = Cat::withCount('sponsorships')->latest('id')->get();

        return view('cat_list', ['cats' => $cats]);
    }
}
