<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {

        $users = [
            [
                'name' => 'Reviewer One',
                'email' => 'reviewer1@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'reviewer'
            ],
            [
                'name' => 'Reviewer Two',
                'email' => 'reviewer2@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'reviewer'
            ],
            [
                'name' => 'Reviewer Three',
                'email' => 'reviewer3@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'reviewer'
            ],
            [
                'name' => 'Reviewer Four',
                'email' => 'reviewer4@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'reviewer'
            ]
        
        ];

        foreach ($users as $user) {
            User::create($user);


        }

       
    }
}
