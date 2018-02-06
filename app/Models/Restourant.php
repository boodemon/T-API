<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restourant extends Model
{
    protected $table = 'restourants';

    public static function field($id = 0, $field='restourant'){
        $row = Restourant::where('id',$id)->first();
        return $row ? $row->$field : false;
    }
}
