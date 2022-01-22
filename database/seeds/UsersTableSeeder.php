<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Roles;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $adminRoles = Roles::where('name', 'admin')->first();
        $userRoles = Roles::where('name', 'user')->first();
        $authorRoles = Roles::where('author', 'author')->first();


        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'phone' => '0123456789'
        ]);
        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'phone' => '0123456789',
            'password' => bcrypt('123456')
        ]);
        $author = User::create([
            'name' => 'author',
            'email' => 'author@gmail.com',
            'phone' => '0123456789',
            'password' => bcrypt('123456')
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);
    }
}
