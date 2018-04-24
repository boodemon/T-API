<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Tracking extends Model
{
    protected $table = 'trackings';
    public static function fieldRows($row,$attach = []){
        return [
            'id'            =>  $row->id ,
            'user_id'       =>  $row->user_id ,
            'admin_id'      =>  $row->admin_id ,
            'admin'         =>  User::field( $row->admin_id ),
            'user'         =>  User::field( $row->user_id ),
            'order_id'      =>  $row->order_id ,
            'tracking_name' =>  $row->tracking_name ,
            'attach'        =>  $attach,
            'created_date'  =>  date('d M Y', strtotime( $row->created_at ) ) ,
            'created_time'  =>  date('H:i', strtotime( $row->created_at ) ) ,
            'created_at'    =>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at'    =>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) ),
        ];

    }
}
