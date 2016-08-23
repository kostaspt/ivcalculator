<?php

namespace IVCalculator;

use BadFunctionCallException;
use Illuminate\Support\Collection;
use IVCalculator\Entities\Pokemon;
use IVCalculator\Exceptions\PokemonNotFound;
use IVCalculator\Traits\InteractsWithFiles;

class Pokedex
{
    use InteractsWithFiles;

    /**
     * @var Collection
     */
    protected $pokemonData;

    public function __construct()
    {
        $this->pokemonData = $this->loadDataFile('pokemon.json');
    }

    /**
     * Search by name and ID for pokemon.
     *
     * @param $needle
     *
     * @return Pokemon
     */
    public function tryToFind($needle)
    {
        try {
            $pokemon = $this->getByName($needle);

            return $pokemon;
        } catch (PokemonNotFound $e) {
            // Do nothing
        }

        try {
            $pokemon = $this->getById($needle);

            return $pokemon;
        } catch (PokemonNotFound $e) {
            // Do nothing
        }
    }

    /**
     * Get pokemon by name.
     *
     * @param $id
     *
     * @return Pokemon
     */
    public function getById($id)
    {
        return $this->getBy('id', $id);
    }

    /**
     * Get pokemon by name.
     *
     * @param $name
     *
     * @return Pokemon
     */
    public function getByName($name)
    {
        return $this->getBy('name', $name);
    }

    /**
     * Get pokemon by a key.
     *
     * @param $key
     * @param $value
     *
     * @throws PokemonNotFound
     *
     * @return Pokemon
     */
    private function getBy($key, $value)
    {
        if (!in_array($key, ['id', 'name', 'stamina', 'attack', 'defense'])) {
            throw new BadFunctionCallException();
        }

        $data = $this->pokemonData->where($key, $value)->first();

        if (is_null($data)) {
            throw new PokemonNotFound();
        }

        return new Pokemon(
            $data->id,
            $data->name,
            $data->stamina,
            $data->attack,
            $data->defense
        );
    }
}
