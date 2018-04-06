<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attach extends Model
{
    protected $table = 'attaches';
    public static function row($row){
        return [
            'id'            => $row->id ,
            'ref_id'        => $row->ref_id ,
            'attach_link'   => $row->attach_link ,
            'attach_img'    => asset('public/images/attach/'. $row->attach_link ),
            'attach_type'   => $row->attach_type ,
            'created_at'    =>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at'    =>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) ),
        ];
    }
}
