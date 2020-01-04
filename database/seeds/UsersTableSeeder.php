<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new \App\User();
        $user->name='admin';
        $user->surname='admin';
        $user->role_id='1';
        $user->password=bcrypt('123qwe');
        $user->email='admin@admin.com';
        $user->active='1';
        $user->phone='123-123-123';
        $user->save();

    }
}
