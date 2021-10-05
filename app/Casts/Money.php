<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Money implements CastsAttributes
{
    /**
     * @var string
     */
    private $priceField;
    /**
     * @var string
     */
    private $currencyField;
    /**
     * @var bool
     */
    private $useMinor;

    public function __construct
    (
        $priceField = 'price',
        $currencyField = 'currency',
        $useMinor = true
    ) {
        $this->priceField = $priceField;
        $this->currencyField = $currencyField;
        $this->useMinor = $useMinor;
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        if (! $this->useMinor) {
            return \Brick\Money\Money::of($attributes[$this->priceField], $attributes[$this->currencyField]);
        }

        return \Brick\Money\Money::ofMinor($attributes[$this->priceField], $attributes[$this->currencyField]);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        if (! $value instanceof \Brick\Money\Money) {
            throw new \InvalidArgumentException(
                sprintf('value must be of type %s', \Brick\Money\Money::class)
            );
        }

        return [
            $this->currencyField => $value->getCurrency()->getCurrencyCode(),
            $this->priceField => $this->useMinor ? $value->getMinorAmount()->toInt() : $value->getAmount()->toFloat(),
        ];
    }
}
