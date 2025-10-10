<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Muhammad Ekanur',
            'username' => 'muhammadekanur',
            'email' => 'Muhammadekanur@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Najlakrnsa',
            'username' => 'najla',
            'email' => 'najlakrnsa124@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Soim Black',
            'username' => 'soimblack',
            'email' => 'soimblack@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'author',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Nak',
            'username' => 'nak',
            'email' => 'ber@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
            'remember_token' => Str::random(10),
        ]);

          User::factory(4)->create();
    }
}
