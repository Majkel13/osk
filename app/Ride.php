<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Ride extends Model
{
    public function instruktorr()
    {
        return $this->belongsTo('App\User','instructor');
    }

    public function kursantt()
    {
        return $this->belongsTo('App\User','student');
    }

    public function status(){
        return $this->belongsTo('App\Status','status_id');
    }

    public function checkData(){
        $mytime = Carbon::now()->subHour(1);
        $dateNow=$mytime->toDateString();
        $timeNow=$mytime->toTimeString();

        if($dateNow < $this->date ||($dateNow==$this->date && $timeNow < $this->time_start) )
    { 
        return true;
    }else return false;
    }

    public function checkDataStudent(){
        $mytime = Carbon::now()->addDay(2);
        $dateNow=$mytime->toDateString();
        $timeNow=$mytime->toTimeString();

        if($dateNow < $this->date ||($dateNow==$this->date && $timeNow < $this->time_start) )
    { 
        return true;
    }else return false;
    }

    public function checkStatus($name){
       return $this->status()->where('name', $name)->exists(); 
    }
}
