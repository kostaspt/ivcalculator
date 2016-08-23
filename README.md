# IV Calculator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kostaspt/ivcalculator.svg?style=flat-square)](https://packagist.org/packages/kostaspt/ivcalculator)
[![Build Status](https://img.shields.io/travis/kostaspt/ivcalculator/master.svg?style=flat-square)](https://travis-ci.org/kostaspt/ivcalculator)
[![StyleCI](https://styleci.io/repos/66166238/shield)](https://styleci.io/repos/66166238)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/32b1d984-212c-48cd-b18a-f6254bc47062.svg?style=flat-square)](https://insight.sensiolabs.com/projects/32b1d984-212c-48cd-b18a-f6254bc47062)
[![Quality Score](https://img.shields.io/scrutinizer/g/kostaspt/ivcalculator.svg?style=flat-square)](https://scrutinizer-ci.com/g/kostaspt/ivcalculator)

Find the possible IVs of a Pokémon.

## Usage
```php
<?php

require('vendor/autoload.php');

$ivCalculator = new IVCalculator\IVCalculator();

// Pokemon, CP, HP, Stardust needed for power up, Was powered up before?
$ivs = $ivCalculator->evaluate('Dragonite', 3280, 149, 9000, false);

var_dump($ivs->toArray());

/*
    Outputs:

    array:5 [
        4 => {#219
            +"attackIV": 13
            +"defenseIV": 6
            +"staminaIV": 9
            +"level": 76
            +"perfection": 0.62
        }
        1 => {#222
            +"attackIV": 15
            +"defenseIV": 8
            +"staminaIV": 10
            +"level": 74
            +"perfection": 0.73
        }
        3 => {#220
            +"attackIV": 9
            +"defenseIV": 15
            +"staminaIV": 10
            +"level": 75
            +"perfection": 0.75
        }
        2 => {#221
            +"attackIV": 12
            +"defenseIV": 12
            +"staminaIV": 11
            +"level": 74
            +"perfection": 0.77
        }
        0 => {#223
            +"attackIV": 15
            +"defenseIV": 9
            +"staminaIV": 12
            +"level": 73
            +"perfection": 0.8
        }
    ]
 */

```

## Credit

Heavily inspired by [andromedado/pokemon-go-iv-calculator](https://github.com/andromedado/pokemon-go-iv-calculator)
