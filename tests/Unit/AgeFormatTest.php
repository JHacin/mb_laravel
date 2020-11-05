<?php

namespace Tests\Unit;

use App\Utilities\AgeFormat;
use Carbon\Carbon;
use Tests\TestCase;

class AgeFormatTest extends TestCase
{
    /**
     * @return void
     */
    public function testAgeString()
    {
        $now = Carbon::now();

        $zeroDays = $now->clone()->subMinutes(45);
        $this->assertEquals('1 dan', AgeFormat::formatToAgeString($zeroDays->diff($now)));

        $onlyDays = $now->clone()->subDays(1);
        $this->assertEquals('1 dan', AgeFormat::formatToAgeString($onlyDays->diff($now)));
        $this->assertEquals('2 dneva', AgeFormat::formatToAgeString($onlyDays->subDay()->diff($now)));
        $this->assertEquals('3 dnevi', AgeFormat::formatToAgeString($onlyDays->subDay()->diff($now)));
        $this->assertEquals('4 dnevi', AgeFormat::formatToAgeString($onlyDays->subDay()->diff($now)));
        $this->assertEquals('5 dni', AgeFormat::formatToAgeString($onlyDays->subDay()->diff($now)));

        $onlyMonths = $now->clone()->subMonths(1)->subDays(6);
        $this->assertEquals('1 mesec', AgeFormat::formatToAgeString($onlyMonths->diff($now)));
        $this->assertEquals('2 meseca', AgeFormat::formatToAgeString($onlyMonths->subMonth()->diff($now)));
        $this->assertEquals('3 meseci', AgeFormat::formatToAgeString($onlyMonths->subMonth()->diff($now)));
        $this->assertEquals('4 meseci', AgeFormat::formatToAgeString($onlyMonths->subMonth()->diff($now)));
        $this->assertEquals('5 mesecev', AgeFormat::formatToAgeString($onlyMonths->subMonth()->diff($now)));

        $onlyYears = $now->clone()->subYears(1)->subDays(1);
        $this->assertEquals('1 leto', AgeFormat::formatToAgeString($onlyYears->diff($now)));
        $this->assertEquals('2 leti', AgeFormat::formatToAgeString($onlyYears->subYear()->diff($now)));
        $this->assertEquals('3 leta', AgeFormat::formatToAgeString($onlyYears->subYear()->diff($now)));
        $this->assertEquals('4 leta', AgeFormat::formatToAgeString($onlyYears->subYear()->diff($now)));
        $this->assertEquals('5 let', AgeFormat::formatToAgeString($onlyYears->subYear()->diff($now)));

        $yearsAndMonths = $now->clone()->subYears(1)->subMonths(1)->subDays(4);
        $this->assertEquals('1 leto in 1 mesec', AgeFormat::formatToAgeString($yearsAndMonths->diff($now)));
        $this->assertEquals('3 leta in 5 mesecev', AgeFormat::formatToAgeString($yearsAndMonths->subYears(2)->subMonths(4)->diff($now)));
    }
}
