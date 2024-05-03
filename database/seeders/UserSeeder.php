<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => env('ADMIN_NAME', 'Administrador'),
            'email' => env('ADMIN_EMAIL', 'admin@admin.com'), 
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password159')) 
        ]);
    }
}
