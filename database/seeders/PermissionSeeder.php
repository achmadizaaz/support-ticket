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
         Permission::create(['name' => 'read users']);
         Permission::create(['name' => 'create users']);
         Permission::create(['name' => 'update users']);
         Permission::create(['name' => 'delete users']);

        //  Create role Super Administrator
         $role = Role::create(['name' => 'Super Administrator']);
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
