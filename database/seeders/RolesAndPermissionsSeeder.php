<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use ReflectionClass;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = new ReflectionClass('App\\Utils\\Permissions');
        $allPermissions = $permissions->getConstants();
        foreach ($allPermissions as $permission) {
            Permission::updateOrCreate(['name' => $permission],['name' => $permission]);
        }

        foreach(UserRole::getValues() as $role){
            Role::updateOrCreate(['name' => $role],['name' => $role])->givePermissionTo(Permission::all());
        }
    }
}
