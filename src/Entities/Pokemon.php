<?php

namespace IVCalculator\Entities;

class Pokemon
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $stamina;

    /**
     * @var int
     */
    public $attack;

    /**
     * @var int
     */
    public $defense;

    /**
     * @param $id
     * @param $name
     * @param $stamina
     * @param $attack
     * @param $defense
     */
    public function __construct($id, $name, $stamina, $attack, $defense)
    {
        $this->id = $id;
        $this->name = $name;
        $this->stamina = $stamina;
        $this->attack = $attack;
        $this->defense = $defense;
    }
}
