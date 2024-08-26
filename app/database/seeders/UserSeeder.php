<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('123456'),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane.hills@example.com',
                'password' => Hash::make('123456'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
