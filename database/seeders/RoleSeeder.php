<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Create roles
        $adminRole = Role::updateOrCreate(
            ['name' => 'Admin']
        );

        $websiteAdminRole = Role::updateOrCreate(
            ['name' => 'Website-admin']
        );

        // ✅ Users and their roles
        $usersWithRoles = [
            'wlsfernandes@gmail.com' => [$adminRole->id, $websiteAdminRole->id],
            'drlizrios@gmail.com' => [$adminRole->id],
        ];

        foreach ($usersWithRoles as $email => $roleIds) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->roles()->syncWithoutDetaching($roleIds);
            }
        }
    }

}
