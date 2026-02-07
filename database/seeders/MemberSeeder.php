<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test member if not exists
        Member::firstOrCreate(
            ['email' => 'member@test.com'],
            [
                'username' => 'testmember',
                'name' => 'Test Member',
                'password' => Hash::make('password'),
                'nim' => '20240001',
                'prodi' => 'Informatika',
                'member_id' => 'PUS202400001',
                'tgl_daftar' => now(),
            ]
        );
    }
}
