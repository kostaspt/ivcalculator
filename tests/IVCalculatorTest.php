<?php

use IVCalculator\IVCalculator;
use IVCalculator\Pokedex;

class IVCalculatorTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_gets_possible_ivs()
    {
        $pokemon = (new Pokedex)->getByName('Zubat');

        $potentialIVs = (new IVCalculator)->evaluate($pokemon, 342, 52, 3000);

        $this->assertCount(27, $potentialIVs);
    }
}
