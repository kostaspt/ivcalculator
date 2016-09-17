<?php

namespace IVCalculator\Entities;

use Illuminate\Support\Collection;

class Evaluation
{
    /**
     * @var Collection
     */
    private $ivs;

    /**
     * @var float
     */
    private $max;

    /**
     * @var float
     */
    public $min;

    /**
     * @var float
     */
    public $avg;

    public function __construct(Collection $ivs)
    {
        $this->ivs = $ivs->map(function (IV $iv) {
            $iv->perfection = $this->calculatePerfection($iv);

            return $iv;
        })->sortBy('perfection');

        $this->max = $this->ivs->first()->perfection;
        $this->min = $this->ivs->last()->perfection;
        $this->avg = round($this->ivs->average('perfection'), 2);
    }

    /**
     * @return Collection
     */
    public function getIVs()
    {
        return $this->ivs;
    }

    /**
     * @return float
     */
    public function getMaxPerfection()
    {
        return $this->max;
    }

    /**
     * @return float
     */
    public function getAveragePerfection()
    {
        return $this->avg;
    }

    /**
     * @return float
     */
    public function getMinPerfection()
    {
        return $this->min;
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
