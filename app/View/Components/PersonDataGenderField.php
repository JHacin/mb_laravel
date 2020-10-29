<?php

namespace App\View\Components;

use App\Models\PersonData;
use Illuminate\View\Component;
use Illuminate\View\View;

class PersonDataGenderField extends Component
{
    /**
     * @var int
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @param int $value
     */
    public function __construct(int $value = PersonData::GENDER_UNKNOWN)
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
        return view('components.person-data-gender-field');
    }
}
