<?php

namespace IVCalculator\Entities;

class IV
{
    /**
     * @var int
     */
    public $attackIV;

    /**
     * @var int
     */
    public $defenseIV;

    /**
     * @var int
     */
    public $staminaIV;

    /**
     * @var int
     */
    public $level;

    /**
     * @var float
     */
    public $perfection;

    public function __construct($attackIV, $defenseIV, $staminaIV, $level)
    {
        $this->attackIV = $attackIV;
        $this->defenseIV = $defenseIV;
        $this->staminaIV = $staminaIV;
        $this->level = $level;
        $this->perfection = 0;
    }
}
