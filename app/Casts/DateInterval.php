<?php

namespace App\Casts;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DateInterval implements CastsAttributes
{
    /**
     * @var string
     */
    private $unit;

    public function __construct(string $unit)
    {
        $this->unit = $unit;
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  float  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('Value must be numeric');
        }

        return (new CarbonInterval(null))->add($this->unit, $value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  float  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        if (! $value instanceof \DateInterval) {
            throw new \InvalidArgumentException('Value must be an instance of ' . \DateInterval::class);
        }

        return CarbonInterval::instance($value)->total($this->unit);
    }
}
