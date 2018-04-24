<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

    public static function toUser($token = ''){
        $base64 = @base64_decode( $token );
        $data = @json_decode( $base64 );
        //echo 'token = '. $token .' | base64 = '. $base64 .'<pre>', print_r( $data ) .'</pre>';
        if( $data  ){
            $user = User::where('username', $data->username)
                        ->where('id',$data->id)
                        ->first();
            if( !$user )
                return false;
            
            return $user;
        }else{ 
            return false;
        }
    }

    public static function field($id = 0,$field='name'){
        $row = User::where('id',$id)->first();
        return $row ? $row->$field : '';
    }

    public function attempt( $user ){

    }
}
