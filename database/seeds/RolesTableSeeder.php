<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=new \App\Role();
        $role->name='Admin';
        $role->save();

        $role=new \App\Role();
        $role->name='Pracownik';
        $role->save();

        $role=new \App\Role();
        $role->name='Kursant';
        $role->save();
    }
}
