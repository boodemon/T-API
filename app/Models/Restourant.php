<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib;
use App\Models\Category;
class Restourant extends Model
{
    protected $table = 'restourants';

    public static function field($id = 0, $field='restourant'){
        $row = Restourant::where('id',$id)->first();
        return $row ? $row->$field : false;
    }

    public static function fieldRows($row){
        return [
            'id'            => $row->id,
            'groups'        => Category::groupName( @json_decode($row->category_id) ),
            'restourant'    => $row->restourant,
            'contact'       => $row->contact ,
            'tel'           => $row->tel,
            'image'         => $row->image,
            'thumb'         => Lib::exsImg( 'public/images/restourant' , $row->image ),
            'active'        => $row->active,
            'created'       => $row->created_at,
            'updated'       => $row->updated_at
        ];
    }

    public static function showContact($id = 0){
        $row = Restourant::where('id',$id)->first();
        if( !$row ) return false;
       return '<p class="bolds">'. $row->restourant .'</p>'
                .'<p>'. $row->contact .'</p>'
                .'<p><span class="bold">Tel. </span>'. $row->tel .'</p>';
        
    }
}
