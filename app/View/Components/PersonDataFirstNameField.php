<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PersonDataFirstNameField extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.person-data-first-name-field');
    }
}
