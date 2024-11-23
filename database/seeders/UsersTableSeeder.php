<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        $admin = User::where('email', 'admin@example.com')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$admin->roles->contains($adminRole)) {
            $admin->roles()->attach($adminRole->id);
        }

        // Librarian User
        $librarian = User::where('email', 'librarian@example.com')->first();
        if (!$librarian) {
            $librarian = User::create([
                'name' => 'Librarian User',
                'email' => 'librarian@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $librarianRole = Role::where('name', 'librarian')->first();
        if ($librarianRole && !$librarian->roles->contains($librarianRole)) {
            $librarian->roles()->attach($librarianRole->id);
        }
    }
}
