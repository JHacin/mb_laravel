<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class PagesController extends Controller
{

    /**
     * Show the homepage.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the cat list.
     *
     * @return Application|Factory|View
     */
    public function catList()
    {
        $cats = Cat::all();

        return view('cat_list', ['cats' => $cats]);
    }
}
