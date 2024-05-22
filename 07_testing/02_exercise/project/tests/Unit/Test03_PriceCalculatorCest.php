<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;

use Price\Calculator;

class Test03_PriceCalculatorCest
{
    public function test(UnitTester $I): void
    {
        $calculator = new Calculator();
        $I->assertNotNull($calculator);
    }
}
