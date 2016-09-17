# IV Calculator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kostaspt/ivcalculator.svg?style=flat-square)](https://packagist.org/packages/kostaspt/ivcalculator)
[![Build Status](https://img.shields.io/travis/kostaspt/ivcalculator/master.svg?style=flat-square)](https://travis-ci.org/kostaspt/ivcalculator)
[![StyleCI](https://styleci.io/repos/66166238/shield)](https://styleci.io/repos/66166238)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/32b1d984-212c-48cd-b18a-f6254bc47062.svg?style=flat-square)](https://insight.sensiolabs.com/projects/32b1d984-212c-48cd-b18a-f6254bc47062)
[![Quality Score](https://img.shields.io/scrutinizer/g/kostaspt/ivcalculator.svg?style=flat-square)](https://scrutinizer-ci.com/g/kostaspt/ivcalculator)

Find the possible IVs of a Pokémon.

## Installation

You can install this package via composer using:

```bash
$ composer require kostaspt/ivcalculator
```

## Usage
```php
<?php

require_once 'vendor/autoload.php';

$ivCalculator = new IVCalculator\IVCalculator();

// Pokemon, CP, HP, Stardust needed for power up, Was powered up before?
$results = $ivCalculator->evaluate('Dragonite', 3280, 149, 9000, false);

var_dump($results->toArray());

/*
    Outputs:

    array:4 [
        "id" => 149
        "name" => "Dragonite"
        "perfection" => array:3 [
            "max" => 0.62
            "min" => 0.8
            "average" => 0.73
        ]
        "ivs" => array:5 [
            4 => IVCalculator\Entities\IV {#56
                +attackIV: 13
                +defenseIV: 6
                +staminaIV: 9
                +level: 76
                +perfection: 0.62
            }
            1 => IVCalculator\Entities\IV {#59
                +attackIV: 15
                +defenseIV: 8
                +staminaIV: 10
                +level: 74
                +perfection: 0.73
            }
            3 => IVCalculator\Entities\IV {#57
                +attackIV: 9
                +defenseIV: 15
                +staminaIV: 10
                +level: 75
                +perfection: 0.75
            }
            2 => IVCalculator\Entities\IV {#58
                +attackIV: 12
                +defenseIV: 12
                +staminaIV: 11
                +level: 74
                +perfection: 0.77
            }
            0 => IVCalculator\Entities\IV {#60
                +attackIV: 15
                +defenseIV: 9
                +staminaIV: 12
                +level: 73
                +perfection: 0.8
            }
        ]
    ]
 */
```

The `$results` variable is a [Collection](https://laravel.com/docs/5.3/collections), so you can use it like this:

```php
echo $results->get('name');

// Outputs: Dragonite
```

or
 
```php
echo $results->get('perfection')->get('average');

// Outputs: 0.73
```

or

```php
$highestIV = $results->get('ivs')->last();

echo $highestIV->perfection;

// Outputs: 0.8
```

## Usage (Command Line)

You can install this package via composer globally using:

```bash
$ composer require global kostaspt/ivcalculator
```

Then, just run:

```bash
$ ivcalculator analyze 'Dragonite' 3280 149 9000
```

![](http://i.imgur.com/pWDkZC3.jpg)

## Credit

Heavily inspired by [andromedado/pokemon-go-iv-calculator](https://github.com/andromedado/pokemon-go-iv-calculator)
