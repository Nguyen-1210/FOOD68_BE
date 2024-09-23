<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRoleWeb = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $cashierRoleWeb = Role::create(['name' => 'cashier', 'guard_name' => 'web']);
        $kitchenRoleApi = Role::create(['name' => 'kitchen', 'guard_name' => 'api']);
        $serveRoleApi = Role::create(['name' => 'serve', 'guard_name' => 'api']);

        $users = User::all();

        foreach ($users as $user) {
            if ($user->email == 'admin@example.com') {
                $user->assignRole($adminRoleWeb);
            } elseif ($user->email == 'cashier@example.com') {
                $user->assignRole($cashierRoleWeb);
            } elseif ($user->email == 'kitchen@example.com') {
                $user->assignRole($kitchenRoleApi);
            } elseif ($user->email == 'serve@example.com') {
                $user->assignRole($serveRoleApi);
            }
        }

    }
}