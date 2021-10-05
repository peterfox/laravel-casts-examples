<?php

namespace App\Casts;

use Geocoder\Location;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Address implements CastsAttributes
{
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
        return \Geocoder\Model\Address::createFromArray(json_decode($value, true));
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
        if (! $value instanceof Location) {
            throw new \InvalidArgumentException();
        }

        return json_encode($value->toArray());
    }
}
