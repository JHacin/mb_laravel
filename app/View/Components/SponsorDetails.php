<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;
use Illuminate\View\View;

class SponsorDetails extends Component
{
    const MISSING_FIRST_NAME_PLACEHOLDER = 'brez imena';
    const MISSING_CITY_PLACEHOLDER = 'neznan kraj';

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
        $viewData = [
            'first_name' => $this->sponsor->first_name ?? self::MISSING_FIRST_NAME_PLACEHOLDER,
            'city' => $this->sponsor->city ?? self::MISSING_CITY_PLACEHOLDER,
        ];

        return view('components.sponsor-details', $viewData);
    }
}
