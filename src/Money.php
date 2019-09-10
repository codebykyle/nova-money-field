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

    /**
     * Currency Code
     * @var string
     */
    protected $currency;

    /**
     * Color class callback
     * @var callable
     */
    protected $colorCallback;

    /**
     * If color support is enabled
     *
     * @var bool
     */
    protected $enableColors = false;

    /**
     * If a positive number is considered a "good thing" for color support
     *
     * @var bool
     */
    protected $upIsGood = true;

    /**
     *
     * Money constructor.
     *
     * @param $name
     * @param null $attribute
     * @param callable|null $resolveCallback
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
    }

    /**
     * Set the currency code for the field
     *
     * @param string $currency_code
     * @return $this
     */
    public function currency($currency_code='USD') {
        $this->currency = $currency_code;
        return $this;
    }

    /**
     * Enable color support for the field, based on the value
     *
     * @param bool $enabled
     * @return $this
     */
    public function enableColors($enabled=true) {
        $this->enableColors = $enabled;
        return $this;
    }

    /**
     * Set if a positive number is a good, or bad thing for color support.
     * Set to true if a positive number is considered "good"
     *
     * @param bool $up_is_good
     * @return $this
     */
    public function upIsGood($up_is_good=true) {
        $this->upIsGood = $up_is_good;
        return $this;
    }

    /**
     * Set a callback which returns a string of the color the value should be.
     *
     * @param $colors_callback
     * @return $this
     */
    public function colors($colors_callback) {
        $this->colorCallback = $colors_callback;
        return $this;
    }

    /**
     * Resolve the field value to a color based on the user callback or
     * using the upIsGood flag
     *
     * @return bool|mixed|string
     * @throws Exception
     */
    public function resolveColor() {
        if (!$this->enableColors) {
            return false;
        }

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
     * The default color callback which uses the UpIsGood flag to determine what color to use
     *
     * @param $value
     * @param $up_is_good
     * @return string
     */
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

    /**
     * Serialize the field to json
     *
     * @return array
     * @throws Exception
     */
    public function jsonSerialize() {
        return array_merge([
            'currency' => $this->currency,
            'color' => $this->resolveColor()
        ], parent::jsonSerialize());
    }
}
