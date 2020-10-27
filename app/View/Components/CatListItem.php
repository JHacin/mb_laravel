<?php

namespace App\View\Components;

use App\Models\Cat;
use Illuminate\View\Component;
use Illuminate\View\View;

class CatListItem extends Component
{
    public $cat;

    /**
     * Create a new component instance.
     *
     * @param Cat $cat
     */
    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.cat-list-item');
    }
}
