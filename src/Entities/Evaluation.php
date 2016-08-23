<?php

namespace IVCalculator\Entities;

use Illuminate\Support\Collection;

class Evaluation
{
    /**
     * @var Collection
     */
    public $ivs;

    public function __construct(Collection $ivs)
    {
        $this->ivs = $ivs->map(function (IV $iv) {
            $iv->perfection = $this->calculatePerfection($iv);

            return $iv;
        })->sortBy('perfection');
    }

    /**
     * @param IV $iv
     *
     * @return float
     */
    private function calculatePerfection(IV $iv)
    {
        $perfection = ($iv->attackIV + $iv->defenseIV + $iv->staminaIV) / 45;

        return floor($perfection * 100) / 100;
    }
}
