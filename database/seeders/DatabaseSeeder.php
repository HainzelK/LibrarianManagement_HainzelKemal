<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
        ]);
        
        // Create an admin user
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');
    
        // Create a librarian user
        $librarian = \App\Models\User::create([
            'name' => 'Librarian User',
            'email' => 'librarian@example.com',
        ]);
        $librarian->assignRole('librarian');
    }
}
