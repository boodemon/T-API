<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Price;
use App\Models\Restourant;
use App\Models\Category;
use App\Lib;
class FoodController extends Controller
{
    public function index($id = 0){
        $rows = Food::where('category_id',$id)->where('active','Y')->orderBy('food_name')->get();
         $category = Category::where('id', $id)->first();
        if( $rows ){
            $jsdata = [];
            foreach( $rows as $row ){
                $jsdata[] = $this->field($row);
            }
            $data = [
                'code' => 200,
                'data' => $jsdata,
                'category'      => $category ? $category->name : '',
                'food_path ' => asset('public/images/foods'),
            ];
        }else{
            $data = [
                'code' => 202,
                'data' => false
            ];
        }
        return response()->json( $data );
    }

    public function show($id){
        $row = Food::where('id',$id)->orderBy('food_name')->first();
       
        if( $row ){
            $category = Category::where('id', $row->category_id)->first();
            $jsdata = $this->field($row);
            $data = [
                'code'          => 200,
                'data'          => $jsdata,
                'category'      => $category ? $category->name : '',
                'food_path '    => asset('public/images/foods'),
            ];
        }else{
            $data = [
                'code' => 202,
                'data' => false
            ];
        }
        return response()->json( $data );
    }
    public function pricelist($food_id = 0){
        $price = Price::where('food_id',$food_id)->get();
        $pres = [];
        if($price){
            foreach($price as $pr){
                $res_id = $pr->restourant_id;
                $pres[] = $this->priceField($pr);
            }
        }
        $data = [
            'data' => $pres,
            'code'  => 200,
        ];
        return response()->json( $data );
    }

    public function field($row){
        return  [
                   'id' => $row->id,
                   'category_id' => $row->category_id,
                   'food_name' => $row->food_name,
                   'kcal' => $row->kcal,
                   'food_image' => Lib::exsImg( 'public/images/foods' , $row->food_image ),
                   'restourants' => $row->restourants,
                   'active' => $row->active,
                   'created_at' => date('Y-m-d H:i:s', strtotime($row->created_at) ),
                   'updated_at' => date('Y-m-d H:i:s', strtotime($row->updated_at) )
                ];
    }

    public function priceField($row){
        return [
            'id'            => $row->id,
            'food_id'       => $row->food_id,
            'category_id'   => $row->category_id,
            'restourant_id' => $row->restourant_id,
            'restourant'    => Restourant::field($row->restourant_id),
            'price'         => $row->price,
            'created_at'    => date('Y-m-d H:i:s', strtotime($row->created_at) ),
            'updated_at'    => date('Y-m-d H:i:s', strtotime($row->updated_at) )
        ];
    }
}
