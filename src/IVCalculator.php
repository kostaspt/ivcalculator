<?php

namespace IVCalculator;

use Illuminate\Support\Collection;
use IVCalculator\Traits\InteractsWithFiles;

class IVCalculator
{
    use InteractsWithFiles;

    /**
     * @var Collection
     */
    protected $levelUpData;

    public function __construct()
    {
        $this->levelUpData = $this->loadDataFile('level_up.json');
    }

    /**
     * @param $pokemonNameOrId
     * @param $cp
     * @param $hp
     * @param $dustCost
     * @param bool $neverUpgraded
     * @return Collection
     */
    public function evaluate($pokemonNameOrId, $cp, $hp, $dustCost, $neverUpgraded = false)
    {
        $pokemon = (new Pokedex)->tryToFind($pokemonNameOrId);

        $possibleIVs = $this->getPossibleIVs($pokemon, $cp, $hp, $dustCost, $neverUpgraded)
            ->map(function($potentialIV) {
                $potentialIV->perfection = $this->calculatePerfection($potentialIV);

                return $potentialIV;
            })
            ->sortBy('perfection');

        return $possibleIVs;
    }

    /**
     * @param $pokemon
     * @param $cp
     * @param $hp
     * @param $dustCost
     * @param bool $neverUpgraded
     * @return Collection
     */
    private function getPossibleIVs($pokemon, $cp, $hp, $dustCost, $neverUpgraded = false)
    {
        $potentialLevels = $this->getPotentialLevels($dustCost, $neverUpgraded);
        $potentialHPIVs = $this->getPotentialHPIVs($potentialLevels, $pokemon, $hp);
        $potentialIVs = $this->getPotentialIVs($potentialHPIVs, $pokemon, $cp);

        return $potentialIVs;
    }

    /**
     * @param $dustCost
     * @param $neverUpgraded
     * @return Collection
     */
    private function getPotentialLevels($dustCost, $neverUpgraded)
    {
        $potentialLevels = $this->levelUpData
            ->where('dust', $dustCost)
            ->sortBy('level');

        if ($neverUpgraded) {
            $potentialLevels->filter(function ($potentialLevel) {
                return $potentialLevel->level % 2 === 0;
            });
        }

        return $potentialLevels;
    }

    /**
     * @param Collection $potentialLevels
     * @param $pokemon
     * @param $hp
     * @return Collection
     */
    private function getPotentialHPIVs(Collection $potentialLevels, $pokemon, $hp)
    {
        $potentialHPIVs = new Collection();

        $potentialLevels->each(function ($levelData) use ($pokemon, $hp, &$potentialHPIVs) {
            (new Collection(range(0, 15)))
                ->each(function ($staminaIV) use ($pokemon, $hp, &$potentialHPIVs, $levelData) {
                    if ($this->testHP($pokemon, $hp, $staminaIV, $levelData)) {
                        $potentialHPIVs->push((object) [
                            'levelData' => $levelData,
                            'iv'        => $staminaIV
                        ]);
                    }
                });
        });

        return $potentialHPIVs;
    }

    /**
     * @param $potentialHPIVs
     * @param $pokemon
     * @param $cp
     * @return Collection
     */
    private function getPotentialIVs($potentialHPIVs, $pokemon, $cp)
    {
        $potentialIVs = new Collection;

        $potentialHPIVs->each(function ($potentialHPIV) use (&$potentialIVs, $pokemon, $cp) {
            $levelData = $potentialHPIV->levelData;
            $staminaIV = $potentialHPIV->iv;

            (new Collection(range(0, 15)))
                ->each(function ($attackIV) use (&$potentialIVs, $pokemon, $cp, $levelData, $staminaIV) {
                    (new Collection(range(0, 15)))
                        ->each(function ($defenseIV) use (&$potentialIVs, $pokemon, $cp, $levelData, $attackIV, $staminaIV) {
                            if ($this->testCP($pokemon, $cp, $attackIV, $defenseIV, $staminaIV, $levelData)) {
                                $potentialIVs->push((object) [
                                    'attackIV'  => $attackIV,
                                    'defenseIV' => $defenseIV,
                                    'staminaIV' => $staminaIV,
                                    'level'     => $levelData->level,
                                ]);
                            }
                        });
                });
        });


        return $potentialIVs;
    }

    /**
     * @param $pokemon
     * @param $hp
     * @param $iv
     * @param $levelData
     * @return bool
     */
    private function testHP($pokemon, $hp, $iv, $levelData)
    {
        return $hp == (int) floor(($pokemon->stamina + $iv) * $levelData->cpScalar);
    }

    /**
     * @param $pokemon
     * @param $cp
     * @param $attackIV
     * @param $defenseIV
     * @param $staminaIV
     * @param $levelData
     * @return bool
     */
    private function testCP($pokemon, $cp, $attackIV, $defenseIV, $staminaIV, $levelData)
    {
        $attackFactor = $pokemon->attack + $attackIV;
        $defenseFactor = pow($pokemon->defense + $defenseIV, 0.5);
        $staminaFactor = pow($pokemon->stamina + $staminaIV, 0.5);
        $scalarFactor = pow($levelData->cpScalar, 2);

        return $cp == floor($attackFactor * $defenseFactor * $staminaFactor * $scalarFactor / 10);
    }

    /**
     * @param $potentialIV
     * @return float
     */
    private function calculatePerfection($potentialIV)
    {
        $perfection = ($potentialIV->attackIV + $potentialIV->defenseIV + $potentialIV->staminaIV) / 45;

	    return floor($perfection * 100) / 100;
    }
}
