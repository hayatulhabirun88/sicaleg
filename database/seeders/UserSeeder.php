<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Hayatul',
                'email' => 'hayatul@gmail.com',
                'email_verified_at' => NULL,
                'password' => Hash::make('123Hayat#'),
                'no_hp' => '',
                'level' => 'admin',
                'wilayah' => '',
                'foto' => '',
                'remember_token' => '',
            ],
            [
                'name' => 'Samsudin',
                'email' => 'samsuddin@gmail.com',
                'email_verified_at' => NULL,
                'password' => Hash::make('pdipyes123'),
                'no_hp' => '',
                'level' => 'admin',
                'wilayah' => '',
                'foto' => '',
                'remember_token' => '',
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }


}
