<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib;
class Food extends Model
{
    protected $table = 'foods';

    public static function field($id = 0, $field='food_name'){
        $row = Food::where('id',$id)->first();
        return $row ? $row->$field : false;
    }

    public static function fieldRows( $row ){
        return  [
            'id' => $row->id,
            'category_id' => $row->category_id,
            'food_name' => $row->food_name,
            'kcal' => $row->kcal,
            'food_image' => Lib::exsImg( 'public/images/foods' , $row->food_image ),
            'restourants' => $row->restourants,
            'active' => $row->active,
            //'rating'     => @json_decode( Rating::Score($row->id,'detail') ),
            'created_at' => date('Y-m-d H:i:s', strtotime($row->created_at) ),
            'updated_at' => date('Y-m-d H:i:s', strtotime($row->updated_at) )
         ];
    }

}
