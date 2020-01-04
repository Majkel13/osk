<?php

use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status=new \App\Status();
        $status->name='wolna';
        $status->save();

        $status=new \App\Status();
        $status->name='anulowana';
        $status->save();

        $status=new \App\Status();
        $status->name='odbyta';
        $status->save();

        $status=new \App\Status();
        $status->name='zaplanowana';
        $status->save();

        $status=new \App\Status();
        $status->name='nieodbyta';
        $status->save();
    }
}
