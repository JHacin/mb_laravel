<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;
use Illuminate\View\View;

class SponsorDetails extends Component
{
    /**
     * @var User
     */
    public $sponsor;

    /**
     * Create a new component instance.
     *
     * @param User $sponsor
     */
    public function __construct(User $sponsor)
    {
        $this->sponsor = $sponsor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.sponsor-details');
    }
}
