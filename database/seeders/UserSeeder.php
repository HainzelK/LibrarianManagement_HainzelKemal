<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create the Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'adminpassword', // Use bcrypt or Hash::make for the password
            'role' => 'admin',
        ]);

        // Create the Librarian User
        User::create([
            'name' => 'Librarian',
            'email' => 'librarian@example.com',
            'password' => 'librarianpassword', // Use bcrypt or Hash::make for the password
            'role' => 'librarian',
        ]);
    }
}
