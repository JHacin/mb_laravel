<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public function __construct(public string $iconClass)
    {
    }

    public function render(): View
    {
        return view('components.icon');
    }
}
