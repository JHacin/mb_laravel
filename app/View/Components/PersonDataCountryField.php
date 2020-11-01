<?php

namespace App\View\Components;

use App\Utilities\CountryList;
use Illuminate\View\Component;
use Illuminate\View\View;

class PersonDataCountryField extends Component
{
    /**
     * @var int
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @param string $value
     */
    public function __construct(string $value = CountryList::DEFAULT)
    {
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.person-data-country-field');
    }
}
