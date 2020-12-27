<?php

namespace App\View\Components\CatList;

use App\Models\Cat;
use App\Utilities\AgeFormat;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;
use Illuminate\View\View;

class CatListItem extends Component
{
    const VALUE_FALLBACK = '/';

    /**
     * @var Cat
     */
    public Cat $cat;

    /**
     * @param Cat $cat
     */
    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
    }

    /**
     * @return View|string
     */
    public function render()
    {
        return view('components.cat-list.cat-list-item', [
            'dateOfArrivalBoter' => $this->getDateOfArrivalBoter(),
            'currentAge' => $this->getCurrentAge(),
        ]);
    }

    /**
     * @return string
     */
    protected function getDateOfArrivalBoter(): string
    {
        if (!$this->cat->date_of_arrival_boter) {
            return self::VALUE_FALLBACK;
        }

        return $this->cat->date_of_arrival_boter->format(config('date.format.default'));
    }

    /**
     * @return string
     */
    protected function getCurrentAge(): string
    {
        if (!$this->cat->date_of_birth) {
            return self::VALUE_FALLBACK;
        }

        $age = $this->cat->date_of_birth->diff(Carbon::now());
        return AgeFormat::formatToAgeString($age);
    }
}
