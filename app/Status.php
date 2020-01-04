<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function jazdy()
    {
        return $this->hasMany('App\Jazdy');
    }

}
