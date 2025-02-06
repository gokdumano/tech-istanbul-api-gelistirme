<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://dummyjson.com/users', [
            'limit'  => 0,
            'select' => ['firstName', 'lastName', 'email', 'password']
        ]);

        $users = $response->json()['users'];

        foreach ($users as $user) {
            User::create([
                'name'     => $user['firstName'] . ' ' . $user['lastName'],
                'email'    => $user['email'],
                'password' => Hash::make($user['password'])
            ]);
        }
    }
}
