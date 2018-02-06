<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    public static function field($id = 0, $field='food_name'){
        $row = Food::where('id',$id)->first();
        return $row ? $row->$field : false;
    }

}
