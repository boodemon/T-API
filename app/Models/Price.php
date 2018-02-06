<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';

    public static function unit($food_id=0){
       return Price::where('food_id',$food_id)->count();
    }

    public static function field($id = 0, $field='food_id'){
        $row = Price::where('id',$id)->first();
        return $row ? $row->$field : false;
    }

}
