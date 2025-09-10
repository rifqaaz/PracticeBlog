<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'edit assigned']);

        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit all posts']);
        Permission::create(['name' => 'delete posts']);

        // Create Roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view users', 'edit users', 'view posts', 'delete posts'
        ]);

        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo(['view users', 'view posts', 'edit assigned']);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('view posts', 'create posts');
    }
}
