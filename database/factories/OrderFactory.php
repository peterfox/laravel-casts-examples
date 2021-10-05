<?php

namespace Database\Factories;

use App\Models\Order;
use Brick\Money\Money;
use Carbon\CarbonInterval;
use Geocoder\Model\AddressBuilder;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => Money::ofMinor(
                $this->faker->numberBetween(100, 1000),
                $this->faker->randomElement(['GBP', 'USD', 'EUR'])
            ),
            'address' => (new AddressBuilder('seeder'))
                ->setCoordinates($this->faker->latitude, $this->faker->longitude)
                ->setPostalCode($this->faker->postcode)
                ->build(),
            'days' => CarbonInterval::months($this->faker->numberBetween(1, 6)),
        ];
    }
}
