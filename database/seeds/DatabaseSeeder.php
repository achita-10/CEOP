<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => '1',
            'usuario'=> 'admin',
            'password' => bcrypt('admin'),
            'Condicion' => '1',
            'ID_Rol'=>'1'
        ]);
    }
}
