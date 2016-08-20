<?php

use IVCalculator\Pokedex;

class PokedexTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_gets_pokemon_by_id_or_name()
    {
        $pokedex = new Pokedex();

        $pokemonByName = $pokedex->tryToFind('Zubat');
        $pokemonById = $pokedex->tryToFind(41);

        $this->checkPokemonData($pokemonByName);
        $this->assertEquals($pokemonByName->id, $pokemonById->id);
        $this->assertEquals($pokemonByName->name, $pokemonById->name);
    }

    /** @test */
    public function it_gets_pokemon_by_name()
    {
        $this->checkPokemonData(
            (new Pokedex())->getByName('Zubat')
        );
    }

    /** @test */
    public function it_does_not_get_invalid_pokemon_by_name()
    {
        $this->assertNull(
            (new Pokedex())->getByName('Mewthree')
        );
    }

    /** @test */
    public function it_gets_pokemon_by_id()
    {
        $this->checkPokemonData(
            (new Pokedex())->getById(41)
        );
    }

    /** @test */
    public function it_does_not_get_invalid_pokemon_by_id()
    {
        $this->assertNull(
            (new Pokedex())->getById(999999)
        );
    }

    private function checkPokemonData($data)
    {
        $this->assertEquals(41, $data->id);
        $this->assertEquals('Zubat', $data->name);
    }
}
