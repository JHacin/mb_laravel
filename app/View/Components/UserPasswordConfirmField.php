<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class UserPasswordConfirmField extends Component
{
    /**
     * @var string
     */
    public $label;

    /**
     * Create a new component instance.
     *
     * @param string|null $label
     */
    public function __construct(string $label = '')
    {
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.user-password-confirm-field');
    }
}
