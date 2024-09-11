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

        // ticket permission
        Permission::create(['name' => 'read-tickets']);
        Permission::create(['name' => 'create-tickets']);
        Permission::create(['name' => 'update-tickets']);
        Permission::create(['name' => 'delete-tickets']);
        Permission::create(['name' => 'read-all-tickets']);
        
        // unit permission
        Permission::create(['name' => 'read-units']);
        Permission::create(['name' => 'create-units']);
        Permission::create(['name' => 'update-units']);
        Permission::create(['name' => 'delete-units']);

        // category permission
        Permission::create(['name' => 'read-categories']);
        Permission::create(['name' => 'create-categories']);
        Permission::create(['name' => 'update-categories']);
        Permission::create(['name' => 'delete-categories']);
        
        // preferensi notif category permission
        Permission::create(['name' => 'read-notif-preferences']);
        Permission::create(['name' => 'create-notif-preferences']);
        Permission::create(['name' => 'update-notif-preferences']);
        Permission::create(['name' => 'delete-notif-preferences']);

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
        $roleAdmin = Role::create(['id' => '01j7fjspk9ke4tqn6xp5w628tj','name' => 'Super Administrator', 'level' => 10, 'is_admin' => 1]);
        $roleAdministrator= Role::create(['id' => '01j7fjspkfr6c2qmz2d16aqrxe','name' => 'Administrator', 'level' => 3, 'is_admin' => 1]);
        $roleStaff= Role::create(['id'=> '01j7fjspknvnr7tw94cqpqfg0m','name' => 'Staff', 'level' => 2, 'is_admin' => 1]);
        $roleDosen= Role::create(['id' => '01j7fjspkvdk2ecvyh69zx97xm','name' => 'Dosen', 'level' => 1, 'is_admin' => 0]);
        $roleTendik= Role::create(['id' => '01j7fjspm1w4hzgaebesd4sggc','name' => 'Tendik', 'level' => 1, 'is_admin' => 0]);
        $roleMahasiswa= Role::create(['id' => '01j7fjspm6xabcej38ew2rbwta', 'name' => 'Mahasiswa', 'level' => 1, 'is_admin' => 0]);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $admin = \App\Models\User::factory()->create([
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'is_active' => 1,
            'password'=> Hash::make('support@pdmti85!'),
        ]);
        $admin->assignRole($roleAdmin);
        // create demo users
        $achmadizaaz = \App\Models\User::factory()->create([
            'name' => 'Achmad Izaaz',
            'username' => 'achmadizaaz',
            'email' => 'achmadizaaz@unmerpas.ac.id',
            'is_active' => 1,
            'password'=> Hash::make('support@pdmti85!'),
        ]);
        $achmadizaaz->assignRole($roleAdmin);
        
    }
}
