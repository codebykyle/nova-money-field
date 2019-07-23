# This is a fork
Needed some extra features from this field. If you're looking for the original, please see:
https://github.com/vyuldashev/nova-money-field

# Money Field for Laravel Nova

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codeByKyle/nova-money-field.svg?style=flat-square)](https://packagist.org/packages/codeByKyle/nova-money-field)
[![Total Downloads](https://img.shields.io/packagist/dt/codeByKyle/nova-money-field.svg?style=flat-square)](https://packagist.org/packages/codeByKyle/nova-money-field)

![screenshot 1](https://raw.githubusercontent.com/codeByKyle/nova-money-field/master/docs/user-details.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require codeByKyle/nova-money-field
```

## Usage

In resource:

```php
// ...
use CodeByKyle\NovaMoneyField\Money;

public function fields(Request $request)
{
    return [
        // ...
        Money::make('Balance'),
    ];
}
```

USD currency is used by default, you can change this by passing second argument:

```php
Money::make('Balance', 'EUR'),
```

You may use `locale` method to define locale for formatting value, by default value will be formatted using browser locale:

```php
Money::make('Balance')->locale('ru-RU'),
```

If you store money values in database in minor units use `storedInMinorUnits` method. Field will automatically convert minor units to base value for displaying and to minor units for storing:

```php
Money::make('Balance', 'EUR')->storedInMinorUnits(),
```

