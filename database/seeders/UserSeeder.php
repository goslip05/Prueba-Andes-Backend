<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Diego jimenez',
            'email' => 'diego.jimenez205@gmail.com',
            'password' => bcrypt('Dev2025*'),
        ])->assignRole('Admin');

        User::create([
            'name' => 'Usuario Guest',
            'email' => 'guest@email.com.co',
            'password' => bcrypt('guest2025*'),
        ])->assignRole('Guest');
    }
}
