<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Lib;
class OrderHead extends Model
{
    protected $table = 'order_heads';

    public function scopeActive($query){
        return $query->where('status','!=','finish')
                    ->where('status','!=','cancelled');
    }

    public static function countNew(){
        return OrderHead::where('status','new')->count();
    }
    public static function fieldRows($row ){
        return [
            'id'         =>  $row->id ,
            'code'       =>  sprintf('%05d',$row->id),
            'user_id'    =>  $row->user_id ,
            'jobname'    =>  $row->jobname ,
            'address'    =>  $row->address ,
            'jobdate'    =>  date( 'd M Y', strtotime($row->jobdate) ) ,
            'jobtime'    =>  date('H:i', strtotime( $row->jobdate ) ) ,
            'remark'     =>  $row->remark ,
            'price'      =>  $row->price ,
            'charge'     =>  $row->charge ,
            'tax'        =>  $row->tax ,
            'status'     =>  $row->status ,
            'status_name'     =>  Lib::statusText( $row->status ) ,
            'created_at' =>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at' =>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) ),
        ];
    }
}
