<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Guest']);

        //Permisos de usuarios para las tareas
        Permission::create(['name' => 'task.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'task.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'task.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'task.delete'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'task.store'])->syncRoles([$role1, $role2]);
    }
}
