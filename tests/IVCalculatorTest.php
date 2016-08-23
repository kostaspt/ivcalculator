<?php

use IVCalculator\IVCalculator;

class IVCalculatorTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_gets_possible_ivs()
    {
        $ivs = (new IVCalculator())->evaluate('Zubat', 342, 52, 3000);

        $this->assertCount(27, $ivs);
    }
}
