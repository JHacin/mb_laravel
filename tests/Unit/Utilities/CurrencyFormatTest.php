<?php

namespace Tests\Unit\Utilities;

use App\Utilities\CurrencyFormat;
use Tests\TestCase;

class CurrencyFormatTest extends TestCase
{
    public function test_formats_number_to_currency_correctly()
    {
        $this->assertEquals('-1,00 €', CurrencyFormat::format(-1));
        $this->assertEquals('5,00 €', CurrencyFormat::format(5));
        $this->assertEquals('15,01 €', CurrencyFormat::format(15.01));
        $this->assertEquals('22,26 €', CurrencyFormat::format(22.25999));
        $this->assertEquals('15.400,56 €', CurrencyFormat::format(15400.5624));
        $this->assertEquals('15.400.300,90 €', CurrencyFormat::format(15400300.9));
    }
}
