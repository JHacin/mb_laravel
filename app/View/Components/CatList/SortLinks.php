<?php

namespace App\View\Components\CatList;

use Illuminate\View\Component;
use Illuminate\View\View;

class SortLinks extends Component
{
    /**
     * @return View|string
     */
    public function render()
    {
        return view('components.cat-list.sort-links');
    }
}
