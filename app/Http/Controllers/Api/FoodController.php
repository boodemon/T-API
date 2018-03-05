<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Food;
class FoodController extends Controller
{
    public function index($id = 0){
        $rows = Food::where('category_id',$id)->orderBy('food_name')->get();
        if( $rows ){
            $data = [
                'code' => 200,
                'data' => $rows,
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
        
    }
}
