<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        
        Permission::create(['name' => 'change-password-users']);
        Permission::create(['name' => 'read-trashed-users']);
        Permission::create(['name' => 'delete-trashed-users']);
        Permission::create(['name' => 'delete-all-trashed-users']);
        Permission::create(['name' => 'restore-trashed-users']);
        Permission::create(['name' => 'restore-all-trashed-users']);
        // create permission roles
        Permission::create(['name' => 'read-roles']);
        Permission::create(['name' => 'create-roles']);
        Permission::create(['name' => 'update-roles']);
        Permission::create(['name' => 'delete-roles']);
        // createa permission
        Permission::create(['name' => 'read-permissions']);
        Permission::create(['name' => 'create-permissions']);
        Permission::create(['name' => 'update-permissions']);
        Permission::create(['name' => 'delete-permissions']);

        // Create permission sync role
        Permission::create(['name' => 'read-sync-permission-roles']);
        Permission::create(['name' => 'create-sync-permission-roles']);
        Permission::create(['name' => 'update-sync-permission-roles']);
        Permission::create(['name' => 'delete-sync-permission-roles']);
        
        // Create permission option
        Permission::create(['name' => 'read-options']);
        Permission::create(['name' => 'create-options']);
        Permission::create(['name' => 'update-options']);
        Permission::create(['name' => 'delete-options']);

        //  Create role Super Administrator
        $role = Role::create(['name' => 'Super Administrator', 'level' => 10]);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'is_active' => 1,
            'password'=> Hash::make('password'),
        ]);
        // create demo users
        $user1 = \App\Models\User::factory()->create([
            'name' => 'Customer',
            'username' => 'customer',
            'email' => 'customer@example.com',
            'is_active' => 1,
            'password'=> Hash::make('password'),
        ]);
        
        $user->assignRole($role);
    }
}
