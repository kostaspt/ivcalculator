<?php

namespace IVCalculator\Entities;

class HPIV
{
    /**
     * @var Level
     */
    public $level;

    /**
     * @var int
     */
    public $staminaIV;

    public function __construct(Level $level, $staminaIV)
    {
        $this->level = $level;
        $this->staminaIV = $staminaIV;
    }
}
