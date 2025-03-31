<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Admin::updateOrCreate(
            ['Email' => 'admin@gmail.com'],
            [
                'Username' => 'Admin',
                'Password' => Hash::make('Admin@123'), 
            ]
        );
    }
}