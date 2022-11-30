<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countUser = User::count();
        if (!$countUser) {
            // Create user
            $user = User::create(
                [
                    'name' => 'admin',
                    'email' => "admin@manhinhcong.com",
                    'password' => Hash::make('123456'),
                ]
            );
            // Create role super_admin
            Role::create(config('roles.admin.roles'));
            // Assign role super admin to user
            $user->assignRole(config('roles.admin.roles'));
            \Log::info('User'. $user);
        }
    }
}
