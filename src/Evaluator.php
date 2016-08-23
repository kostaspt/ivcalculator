<?php

namespace IVCalculator;

use Illuminate\Support\Collection;
use IVCalculator\Entities\Evaluation;
use IVCalculator\Entities\HPIV;
use IVCalculator\Entities\IV;
use IVCalculator\Entities\Level;
use IVCalculator\Entities\Pokemon;
use IVCalculator\Traits\InteractsWithFiles;

class Evaluator
{
    use InteractsWithFiles;

    /**
     * @var Collection
     */
    private $potentialLevels;

    /**
     * @var Collection
     */
    private $potentialHPIVs;

    /**
     * @var Collection
     */
    private $potentialIVs;

    /**
     * @var Collection
     */
    protected $levelUpData;

    public function __construct()
    {
        $this->levelUpData = $this->loadDataFile('level_up.json');

        $this->potentialLevels = new Collection();
        $this->potentialHPIVs = new Collection();
        $this->potentialIVs = new Collection();
    }

    /**
     * @param Pokemon $pokemon
     * @param $cp
     * @param $hp
     * @param $dustCost
     * @param bool $neverUpgraded
     *
     * @return Evaluation
     */
    public function process(Pokemon $pokemon, $cp, $hp, $dustCost, $neverUpgraded = false)
    {
        $this->findPotentialLevels($dustCost, $neverUpgraded)
            ->findPotentialHPIVs($pokemon, $hp)
            ->findPotentialIVs($pokemon, $cp);

        return new Evaluation($this->potentialIVs);
    }

    /**
     * @param $dustCost
     * @param $neverUpgraded
     *
     * @return $this
     */
    private function findPotentialLevels($dustCost, $neverUpgraded)
    {
        $this->potentialLevels = $this->levelUpData
            ->where('dust', $dustCost)
            ->sortBy('level');

        if ($neverUpgraded) {
            $this->potentialLevels->filter(function ($potentialLevel) {
                return $potentialLevel->level % 2 === 0;
            });
        }

        return $this;
    }

    /**
     * @param Pokemon $pokemon
     * @param $hp
     *
     * @return $this
     */
    private function findPotentialHPIVs(Pokemon $pokemon, $hp)
    {
        foreach ($this->potentialLevels as $data) {
            $level = new Level($data->level, $data->dust, $data->candy, $data->cpScalar);

            foreach (range(0, 15) as $staminaIV) {
                if ($this->testHP($pokemon, $level, $hp, $staminaIV)) {
                    $hpiv = new HPIV($level, $staminaIV);

                    $this->potentialHPIVs->push($hpiv);
                }
            };
        };

        return $this;
    }

    /**
     * @param Pokemon $pokemon
     * @param $cp
     *
     * @return $this
     */
    private function findPotentialIVs(Pokemon $pokemon, $cp)
    {
        foreach ($this->potentialHPIVs as $hpiv) {
            foreach (range(0, 15) as $attackIV) {
                foreach (range(0, 15) as $defenseIV) {
                    if ($this->testCP($pokemon, $hpiv->level, $cp, $attackIV, $defenseIV, $hpiv->staminaIV)) {
                        $iv = new IV($attackIV, $defenseIV, $hpiv->staminaIV, $hpiv->level->level);

                        $this->potentialIVs->push($iv);
                    }
                };
            };
        };

        return $this;
    }

    /**
     * @param Pokemon $pokemon
     * @param Level $level
     * @param $cp
     * @param $attackIV
     * @param $defenseIV
     * @param $staminaIV
     *
     * @return bool
     */
    private function testCP(Pokemon $pokemon, Level $level, $cp, $attackIV, $defenseIV, $staminaIV)
    {
        $attackFactor = $pokemon->attack + $attackIV;
        $defenseFactor = pow($pokemon->defense + $defenseIV, 0.5);
        $staminaFactor = pow($pokemon->stamina + $staminaIV, 0.5);
        $scalarFactor = pow($level->cpScalar, 2);

        return $cp == floor($attackFactor * $defenseFactor * $staminaFactor * $scalarFactor / 10);
    }

    /**
     * @param Pokemon $pokemon
     * @param Level $level
     * @param $hp
     * @param $staminaIV
     *
     * @return bool
     */
    private function testHP(Pokemon $pokemon, Level $level, $hp, $staminaIV)
    {
        return $hp == (int) floor(($pokemon->stamina + $staminaIV) * $level->cpScalar);
    }
}
