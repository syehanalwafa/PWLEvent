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
                'name' => 'Admin Event',
                'email' => 'admin@event.com',
                'password' => Hash::make('admin123'),
                'role' => 'Administrator',
                'status' => 'ACTIVE',
                'created_at' => now(),
            ],
            [
                'name' => 'Tim Keuangan 1',
                'email' => 'keuangan@event.com',
                'password' => Hash::make('keuangan123'),
                'role' => 'Tim Keuangan',
                'status' => 'ACTIVE',
                'created_at' => now(),
            ],
            [
                'name' => 'Panitia Pelaksana 1',
                'email' => 'panitia@event.com',
                'password' => Hash::make('panitia123'),
                'role' => 'panitia pelaksana kegiatan',
                'status' => 'ACTIVE',
                'created_at' => now(),
            ],
            [
                'name' => 'Anggota Member 1',
                'email' => 'member1@event.com',
                'password' => Hash::make('member123'),
                'role' => 'Member',
                'status' => 'ACTIVE',
                'created_at' => now(),
            ],
        ]);
    }
}
