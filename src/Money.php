<?php

namespace CodeByKyle\NovaMoneyField;

use Money\Currency;
use Laravel\Nova\Fields\Number;
use Money\Currencies\ISOCurrencies;
use Money\Currencies\BitcoinCurrencies;
use Money\Currencies\AggregateCurrencies;
use Laravel\Nova\Http\Requests\NovaRequest;
use Exception;

class Money extends Number
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-money-field';

    protected $currency;
    protected $colorCallback;
    protected $upIsGood = true;

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
    }

    public function currency($currency_code='USD') {
        $this->currency = $currency_code;
        return $this;
    }

    public function colors($colors_callback) {
        $this->colorCallback = $colors_callback;
        return $this;
    }

    public function upIsGood($up_is_good = true) {
        $this->upIsGood = $up_is_good;
        return $this;
    }

    protected function defaultColorCallback($value, $up_is_good) {
        $good_color = "text-success-dark";
        $default_color = "text-90";;
        $bad_color = "text-danger-dark";


        if ($value == 0 || empty($value)) {
            return $default_color;
        }

        if ($up_is_good) {
            if ($value > 0) {
                return $good_color;
            } else {
                return $bad_color;
            }
        } else {
            if ($value > 0) {
                return $bad_color;
            }  else {
                return $good_color;
            }
        }
    }

    public function resolveColor() {
        try {
            if (isset($this->colorCallback)) {
                return call_user_func($this->colorCallback, $this->value, $this->upIsGood);
            }

            return $this->defaultColorCallback($this->value, $this->upIsGood);
        } catch (Exception $e) {
            throw new Exception("Error trying to get the color for {$this->value}]");
        }
    }

    /**
     * Set the alignment of the field to right-aligned
     *
     * @return $this
     */
    public function alignRight()
    {
        $this->textAlign = 'right';
        return $this;
    }

    public function jsonSerialize() {
        return array_merge([
            'currency' => $this->currency,
            'color' => $this->resolveColor()
        ], parent::jsonSerialize());
    }
}
