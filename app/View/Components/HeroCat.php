<?php

namespace App\View\Components;

use App\Models\Cat;
use App\Utilities\AgeFormat;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeroCat extends Component
{
    public Cat $cat;

    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
    }

    public function render(): View
    {
        $durationOfStayDiff = $this->cat->date_of_arrival_mh->diff(Carbon::now());
        $durationOfStay = AgeFormat::formatToAgeString($durationOfStayDiff);

        return view('components.hero-cat', [
            'photo_url' => $this->cat->first_photo_url,
            'duration_of_stay' => $durationOfStay,
        ]);
    }
}
