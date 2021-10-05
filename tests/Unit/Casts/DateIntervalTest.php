<?php

namespace Tests\Unit\Casts;

use App\Casts\DateInterval;
use App\Models\Order;
use Carbon\CarbonInterval;
use PHPUnit\Framework\TestCase;

class DateIntervalTest extends TestCase
{
    public function test_it_gets_the_value_from_the_database()
    {
        $cast = new DateInterval('days');

        $interval = $cast->get(new Order(), 'days', 10, ['days' => 10]);

        $this->assertInstanceOf(CarbonInterval::class, $interval);
        $this->assertSame(10, $interval->total('days'));
    }

    public function test_it_sets_the_value_from_the_database()
    {
        $cast = new DateInterval('days');
        $interval = (new CarbonInterval(null))->add('days', 10);

        $days = $cast->set(new Order(), 'days', $interval, ['days' => 10]);

        $this->assertIsNumeric($days);
        $this->assertSame(10, $days);
    }
}
