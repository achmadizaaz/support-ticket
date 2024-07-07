<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions users
        Permission::create(['name' => 'read-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'update-users']);
        Permission::create(['name' => 'delete-users']);
        // create permission roles
        Permission::create(['name' => 'read-roles']);
        Permission::create(['name' => 'create-roles']);
        Permission::create(['name' => 'update-roles']);
        Permission::create(['name' => 'delete-roles']);

        // Create permission sync role
        Permission::create(['name' => 'read-sync-permission-role']);
        Permission::create(['name' => 'create-sync-permission-role']);
        Permission::create(['name' => 'update-sync-permission-role']);
        Permission::create(['name' => 'delete-sync-permission-role']);

        //  Create role Super Administrator
        $role = Role::create(['name' => 'Super Administrator', 'level' => 10]);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
        ]);
        
        $user->assignRole($role);
    }
}
