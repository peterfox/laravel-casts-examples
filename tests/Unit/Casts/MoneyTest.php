<?php

namespace Tests\Unit\Casts;

use App\Casts\Money;
use App\Models\Order;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function test_it_gets_the_value_from_the_database()
    {
        $cast = new Money('price', 'currency');

        $money = $cast->get(new Order(), 'money', null, ['price' => 1000, 'currency' => 'GBP']);

        $this->assertInstanceOf(\Brick\Money\Money::class, $money);
        $this->assertSame(10.00, $money->getAmount()->toFloat());
        $this->assertSame('GBP', $money->getCurrency()->getCurrencyCode());
    }

    public function test_it_sets_the_value_from_the_database()
    {
        $cast = new Money('price', 'currency');
        $money = \Brick\Money\Money::of(10, 'GBP');

        $attributes = $cast->set(new Order(), 'money', $money, []);

        $this->assertSame([
            'currency' => 'GBP',
            'price' => 1000,
        ], $attributes);
    }
}
