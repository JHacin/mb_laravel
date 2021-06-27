<?php

namespace App\View\Components;

use App\Models\PersonData;
use Illuminate\View\Component;
use Illuminate\View\View;

class SponsorDetails extends Component
{
    const MISSING_FIRST_NAME_PLACEHOLDER = 'brez imena';
    const MISSING_CITY_PLACEHOLDER = 'neznan kraj';

    /**
     * @var PersonData
     */
    public PersonData $sponsor;

    /**
     * Create a new component instance.
     *
     * @param PersonData $sponsor
     */
    public function __construct(PersonData $sponsor)
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
