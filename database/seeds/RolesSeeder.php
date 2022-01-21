<?php

use Illuminate\Database\Seeder;

use App\Roles;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::truncate();
        DB::table('roles_user')->truncate();

        Roles::create(['name' => 'admin']);
        Roles::create(['name' => 'user']);
    }
}
