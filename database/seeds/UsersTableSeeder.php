<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'Administrador',
            'last_name' => 'Washington',
            'email' => 'admin@consulting.com',
            'password' => bcrypt('123456'),
            'avatar'    => '3.jpg'
        ];

        User::insert($data);

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\User',
            'model_id' => 1
        ]);
    }
}
