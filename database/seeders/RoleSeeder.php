<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles if they don't exist
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }
        
        if (!Role::where('name', 'librarian')->exists()) {
            Role::create(['name' => 'librarian']);
        }
    }
}