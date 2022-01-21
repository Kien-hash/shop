<?php

use Illuminate\Database\Seeder;
use App\Delivery;

class DefaultDelivery extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Delivery::truncate();
        Delivery::create([
            'matp' => 0,
            'maqh' => 0,
            'xaid' => 0,
            'fee' => 25000
        ]);
    }
}
