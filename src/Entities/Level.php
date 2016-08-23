<?php

namespace IVCalculator\Entities;

class Level
{
    /**
     * @var int
     */
    public $level;

    /**
     * @var int
     */
    public $dust;

    /**
     * @var int
     */
    public $candy;

    /**
     * @var float
     */
    public $cpScalar;

    public function __construct($level, $dust, $candy, $cpScalar)
    {
        $this->level = $level;
        $this->dust = $dust;
        $this->candy = $candy;
        $this->cpScalar = $cpScalar;
    }
}
