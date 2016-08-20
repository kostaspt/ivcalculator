# IV Calculator

![](https://img.shields.io/codeship/76c62ad0-4942-0134-a5b9-16ec256c4313.svg)

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

Heavily inspired by (pokemon-go-iv-calculator)[https://github.com/andromedado/pokemon-go-iv-calculator]
