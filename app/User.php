<?php

namespace HoursLoad;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'Users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password','remember_token', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'idUser';

    public static function changePass($id, $pass){
        $update = DB::table('Users')
            ->where('idUser',$id)
            ->update(['password' =>$pass]);
        return true;

    }

}
