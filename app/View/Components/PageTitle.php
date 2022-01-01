<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageTitle extends Component
{
    public function __construct(public string $text)
    {
    }

    public function render(): View
    {
        return view('components.page-title');
    }
}
