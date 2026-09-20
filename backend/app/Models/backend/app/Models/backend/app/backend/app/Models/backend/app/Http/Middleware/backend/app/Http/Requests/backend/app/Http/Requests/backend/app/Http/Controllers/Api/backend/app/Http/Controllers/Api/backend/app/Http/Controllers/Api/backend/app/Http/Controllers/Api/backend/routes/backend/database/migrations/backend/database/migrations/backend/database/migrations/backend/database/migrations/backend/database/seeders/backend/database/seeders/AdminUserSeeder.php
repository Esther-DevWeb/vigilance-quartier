<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Responsable Quartier',
            'email' => 'admin@vigilance-quartier.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
