<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'full_name' => 'User 1',
            'username' => 'User 1',
            'email' => 'user1@example.com',
            'password' => Hash::make('User1'),
            'profile_picture' => 'https://thumbs.dreamstime.com/z/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg?ct=jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'full_name' => 'User 2',
            'username' => 'User 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('User2'),
            'profile_picture' => 'https://thumbs.dreamstime.com/z/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg?ct=jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'full_name' => 'User 3',
            'username' => 'User 3',
            'email' => 'user3@example.com',
            'password' => Hash::make('User3'),
            'profile_picture' => 'https://thumbs.dreamstime.com/z/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg?ct=jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
