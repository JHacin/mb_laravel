<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class UserEmailField extends Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * Create a new component instance.
     *
     * @param string $name
     */
    public function __construct(string $name = 'email')
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.user-email-field');
    }
}
