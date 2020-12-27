<?php

namespace App\View\Components\CatList;

use App\Models\Cat;
use Illuminate\View\Component;
use Illuminate\View\View;

class CatListItem extends Component
{
    public Cat $cat;

    /**
     * @param Cat $cat
     */
    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
    }

    /**
     * @return View|string
     */
    public function render()
    {
        return view('components.cat-list.cat-list-item');
    }
}
