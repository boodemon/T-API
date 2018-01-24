<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public static function queryJson(){
        $rows = Category::orderBy('name')->get();
        $json = [];
        if( $rows ){
            foreach( $rows as $row ){
                $json[$row->id] = [
                    'id' => $row->id,
                    'name'  => $row->name,
                    'image' => $row->image,
                    'type'  => $row->type,
                    'active'    => $row->active,
                    'sort'      => $row->category_sort,
                    'created'   => $row->created_at,
                    'updated'   => $row->updated_at
                ];
            }
        }
        return $json;
    }
}
