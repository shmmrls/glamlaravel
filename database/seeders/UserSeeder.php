<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'               => 'GlamEssentials AdminShaFaye',
                'email'              => 'glamessentialscompany@gmail.com',
                'email_verified_at'  => now(),
                'password'           => Hash::make('password'),
                'img_name'           => null,
                'is_active'          => true,
                'role'               => 'admin',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Trisha Mia Morales',
                'email'              => 'moralestrishamia@gmail.com',
                'email_verified_at'  => now(),
                'password'           => Hash::make('password'),
                'img_name'           => null,
                'is_active'          => true,
                'role'               => 'customer',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}