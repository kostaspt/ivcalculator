<?php

namespace IVCalculator;

use Illuminate\Support\Collection;

class IVCalculator
{
    /**
     * @param $pokemonNameOrId
     * @param $cp
     * @param $hp
     * @param $dustCost
     * @param bool $neverUpgraded
     *
     * @return Collection
     */
    public function evaluate($pokemonNameOrId, $cp, $hp, $dustCost, $neverUpgraded = false)
    {
        $pokemon = (new Pokedex())->tryToFind($pokemonNameOrId);

        $evaluation = (new Evaluator())->process($pokemon, $cp, $hp, $dustCost, $neverUpgraded);

        return collect([
            'id'         => $pokemon->id,
            'name'       => $pokemon->name,
            'perfection' => collect([
                'max'     => $evaluation->getMaxPerfection(),
                'min'     => $evaluation->getMinPerfection(),
                'average' => $evaluation->getAveragePerfection(),
            ]),
            'ivs' => $evaluation->getIVs(),
        ]);
    }
}
