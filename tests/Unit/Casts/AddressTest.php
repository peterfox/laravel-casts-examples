<?php

namespace Tests\Unit\Casts;

use App\Casts\Address;
use App\Models\Order;
use Geocoder\Model\AddressBuilder;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function test_it_gets_the_value_from_the_database()
    {
        $cast = new Address();

        $json = json_encode((new AddressBuilder('seeder'))
            ->setCoordinates(0.1, 0.01)
            ->setPostalCode('AA10 AB1')
            ->build()
            ->toArray());

        $address = $cast->get(new Order(), 'address', $json, ['address' => $json]);

        $this->assertInstanceOf(\Geocoder\Model\Address::class, $address);
    }

    public function test_it_sets_the_value_from_the_database()
    {
        $cast = new Address();

        $address = (new AddressBuilder('seeder'))
            ->setCoordinates(0.1, 0.01)
            ->setPostalCode('AA10 AB1')
            ->build();

        $json = $cast->set(new Order(), 'address', $address, ['address' => json_encode($address->toArray())]);

        $this->assertIsString($json);
        $this->assertIsArray(json_decode($json, true));
    }
}
