<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'NOC Mahaga',
            'email' => 'noc@mahaga.com',
            'password' => bcrypt('mahaga2024!'), // Ubah password sesuai kebutuhan
        ]);
    }
}
