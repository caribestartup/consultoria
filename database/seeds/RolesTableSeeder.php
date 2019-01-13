<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['Administrador', '#EE6255'],
            ['Jefe', '#79C944'],
            ['Empleado', '#FFAD00'],
        ];

        foreach($roles as $role)
        {
            Role::create(['name' => $role[0], 'color' => $role[1]]);
        }
    }
}
