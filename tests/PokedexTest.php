<?php

use IVCalculator\Entities\Pokemon;
use IVCalculator\Exceptions\PokemonNotFound;
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
        $pokemon = (new Pokedex())->getByName('Zubat');

        $this->checkPokemonData($pokemon);
    }

    /** @test */
    public function it_does_not_get_invalid_pokemon_by_name()
    {
        $this->expectException(PokemonNotFound::class);

        (new Pokedex())->getByName('Mewthree');
    }

    /** @test */
    public function it_gets_pokemon_by_id()
    {
        $pokemon = (new Pokedex())->getById(41);

        $this->checkPokemonData($pokemon);
    }

    /** @test */
    public function it_does_not_get_invalid_pokemon_by_id()
    {
        $this->expectException(PokemonNotFound::class);

        (new Pokedex())->getById(999999);
    }

    private function checkPokemonData(Pokemon $pokemon)
    {
        $this->assertEquals(41, $pokemon->id);
        $this->assertEquals('Zubat', $pokemon->name);
    }
}
