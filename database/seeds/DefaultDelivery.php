<?php

use Illuminate\Database\Seeder;

class DefaultDelivery extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deliveries')->insert([
            [
                'matp' => 0,
                'maqh' => 0,
                'xaid' => 0,
                'fee' => 25000
            ],
        ]);
    }
}
