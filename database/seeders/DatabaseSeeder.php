<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class DatabaseSeeder extends Seeder
{
    use WithFaker;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpFaker();
        $this->faker->seed('123');

        Order::factory()->count(10)->create();
    }
}
