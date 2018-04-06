<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    public static function sender($rec = 0,$sender=0,$subject='',$message=''){
        $row = new Message;
        $row->inbox_id = $rec;
        $row->outbox_id = $sender;
        $row->subject = $subject;
        $row->message = $message;
        $row->save();

    }
    public static function field($row){
        return [
            'id'        =>  $row->id ,
            'inbox_id'  =>  $row->inbox_id ,
            'outbox_id' =>  $row->outbox_id ,
            'subject'   =>  $row->subject ,
            'message'   =>  $row->message ,
            'created_at'=>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at'=>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) ),
        ];
    }
}
