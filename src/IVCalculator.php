<?php

namespace IVCalculator;

use IVCalculator\Entities\Evaluation;

class IVCalculator
{
    /**
     * @param $pokemonNameOrId
     * @param $cp
     * @param $hp
     * @param $dustCost
     * @param bool $neverUpgraded
     *
     * @return Evaluation
     */
    public function evaluate($pokemonNameOrId, $cp, $hp, $dustCost, $neverUpgraded = false)
    {
        $pokemon = (new Pokedex())->tryToFind($pokemonNameOrId);

        return (new Evaluator())->process($pokemon, $cp, $hp, $dustCost, $neverUpgraded)->ivs;
    }
}
