<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
class BasicAdminPermissionSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // create permissions
        $permissions = [
            'Dashobard',
            'User',
            'permission list',
            'permission create',
            'permission edit',
            'permission delete',
            'role list',
            'role create',
            'role edit',
            'role delete',
            'user list',
            'user create',
            'user edit',
            'user delete',
            'gaji list',
            'gaji create',
            'gaji edit',
            'gaji delete',
            'pegawai list',
            'pegawai create',
            'pegawai edit',
            'pegawai delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('permission list');
        $role1->givePermissionTo('permission create');
        $role1->givePermissionTo('permission edit');
        $role1->givePermissionTo('permission delete');

        $role1->givePermissionTo('role list');
        $role1->givePermissionTo('role create');
        $role1->givePermissionTo('role edit');
        $role1->givePermissionTo('role delete');

        $role1->givePermissionTo('user list');
        $role1->givePermissionTo('user create');
        $role1->givePermissionTo('user edit');
        $role1->givePermissionTo('user delete');


        $role2 = Role::create(['name' => 'pegawai']);
        $role2->givePermissionTo('gaji list');
        $role2->givePermissionTo('gaji create');
        $role2->givePermissionTo('gaji edit');
        $role2->givePermissionTo('gaji delete');

        $role2->givePermissionTo('pegawai list');
        $role2->givePermissionTo('pegawai create');
        $role2->givePermissionTo('pegawai edit');
        $role2->givePermissionTo('pegawai delete');

        $role3 = Role::create(['name' => 'super-admin']);
        foreach ($permissions as $permission) {
            $role3->givePermissionTo($permission);
        }
        // // gets all permissions via Gate::before rule; see AuthServiceProvider
        // // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
        ]);
        $user->assignRole($role3);


        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@gmail.com',
        ]);
        $user->assignRole($role2);
    }
}
