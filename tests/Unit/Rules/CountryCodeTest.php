<?php

namespace Tests\Unit;

use App\Rules\CountryCode;
use App\Utilities\CountryList;
use Tests\TestCase;

class CountryCodeTest extends TestCase
{

    /**
     * @return void
     */
    public function test_validates_correctly()
    {
        $rule = new CountryCode();

        $this->assertTrue($rule->passes('', CountryList::DEFAULT));
        $this->assertFalse($rule->passes('', 'ABCDEFG'));
    }
}
