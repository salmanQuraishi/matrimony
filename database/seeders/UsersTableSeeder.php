<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'dummyid' => 'TOP0001',
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'mobile' => '7409214495',
                'password' => Hash::make('123456'),
            ],
            [
                'dummyid' => 'TOP0002',
                'name' => 'salman quraishi',
                'mobile' => '9149089862',
                'password' => Hash::make('123456'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

