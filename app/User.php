<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role)
    {
        return User::where('role_id', $role)->get();
    }

    public function hasRolee($role)
    {
        if($this->role()->where('name', $role)->first()){
            return true;
        }
        return false;
    }
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function isAdministrator() {
        return $this->role()->where('name', 'Admin')->exists();
     }

     public function isPracownik() {
        return $this->role()->where('name', 'Pracownik')->exists();
     }

     public function jazdy()
    {
        return $this->hasMany('App\Jazdy');
    }

}
