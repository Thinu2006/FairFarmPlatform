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
            ['Email' => 'thinudifernando@gmail.com'], // Match by email
            [
                'Username' => 'Admin',
                'Password' => Hash::make('Admin@123'), // Update or create these fields
            ]
        );
    }
}