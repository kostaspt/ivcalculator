<?php

use IVCalculator\Exceptions\PokemonNotFound;
use IVCalculator\IVCalculator;

class IVCalculatorTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_gets_possible_ivs()
    {
        $results = (new IVCalculator())->evaluate('Zubat', 342, 52, 3000);

        $this->assertCount(27, $results->get('ivs'));
    }

    /** @test */
    public function it_does_not_gets_possible_ivs_for_unknown_pokemons()
    {
        $this->expectException(PokemonNotFound::class);

        $results = (new IVCalculator())->evaluate('Mewthree', 342, 52, 3000);

        $this->assertCount(27, $results->get('ivs'));
    }

    /** @test */
    public function it_does_not_gets_possible_ivs_for_null_pokemon()
    {
        $this->expectException(PokemonNotFound::class);

        $results = (new IVCalculator())->evaluate('Mewthree', 342, 52, 3000);

        $this->assertCount(27, $results->get('ivs'));
    }
}
