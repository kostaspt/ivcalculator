<?php

namespace IVCalculator;

use BadFunctionCallException;
use Illuminate\Support\Collection;
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
        $this->pokemonData = new Collection(
            $this->parseFile(__DIR__ . '/data/pokemon.json')
        );
    }

    /**
     * Search by name and ID for pokemon.
     *
     * @param $needle
     * @return mixed
     */
    public function tryToFind($needle)
    {
        if ($pokemon = $this->getByName($needle)) {
            return $pokemon;
        }

        if ($pokemon = $this->getById($needle)) {
            return $pokemon;
        }

        return null;
    }

    /**
     * Get pokemon by name.
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->getBy('id', $id);
    }

    /**
     * Get pokemon by name.
     *
     * @param $name
     * @return mixed
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
     * @return mixed
     * @throws BadFunctionCallException
     */
    private function getBy($key, $value)
    {
        if (! in_array($key, ['id', 'name', 'stamina', 'attack', 'defense'])) {
            throw new BadFunctionCallException;
        }

        $pokemon = $this->pokemonData->where($key, $value)->first();

        return $pokemon;
    }
}
