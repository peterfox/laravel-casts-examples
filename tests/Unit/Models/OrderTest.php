<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use Brick\Money\Money;
use Geocoder\Model\AddressBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_the_days()
    {
        /** @var Order $order */
        $order = Order::create([
            'days' => $interval = now()
                ->startOfDay()
                ->diffAsCarbonInterval(
                    now()
                        ->addDays(10)
                        ->startOfDay()
                ),
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'days' => 10,
        ]);

        $order->refresh();

        $this->assertEquals($interval, $order->days);
    }

    public function test_it_stores_the_money()
    {
        /** @var Order $order */
        $order = Order::create([
            'price' => $money = Money::of(10, 'GBP')
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'price' => 1000,
            'currency' => 'GBP',
        ]);

        $order->refresh();

        $this->assertEquals($money, $order->price);
    }

    public function test_it_stores_the_address()
    {
        /** @var Order $order */
        $order = Order::create([
            'address' => $address = (new AddressBuilder('tests'))
                ->setPostalCode('AA10 AB1')
                ->build()
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'address->postalCode' => 'AA10 AB1',
        ]);

        $order->refresh();

        $this->assertEquals($address, $order->address);
    }
}
