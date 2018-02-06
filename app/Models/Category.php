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
    public static function groupName($arr = []){
        $data = [];
        $group = Category::queryJson();
        if( is_array($arr) || is_object($arr) ){
            foreach( $arr as $dx => $ar ){
                $data[] = $group[$ar]['name'];
            }
        }
        return $data ? implode(', ',$data) : '';
    }

    public static function option($selected = ''){
        $rows = Category::orderBy('name')->get();
        $opt = '';
        if($rows){
            foreach( $rows as $row ){
                $opt .= '<option value="'. $row->id .'" '. ( $row->id == $selected ? 'selected' : '' ) .'>'. $row->name .'</option>'."/n/t";
            }
        }
        return $opt;
    }

    public static function field($id = 0, $field='name'){
        $row = Category::where('id',$id)->first();
        return $row ? $row->$field : false;
    }

    
}
