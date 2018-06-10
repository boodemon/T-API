<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib;
use App\User;
use App\Models\Restourant;
use App\Models\Food;
class Rating extends Model
{
    protected $table = 'ratings';
    public static function fieldRows($row){
        if( !$row ) return false;
        $users = User::where('id',$row->user_id)->first();
        $foods = Food::where('id',$row->food_id)->first();
        $restourants = Restourant::where('id',$row->restourant_id)->first();
        return [
                'id'            => $row->id ,
                'user_id'       => $row->user_id ,
                'order_id'      => $row->order_id ,
                'user'          => User::fieldRows($users),
                'detail_id'     => $row->detail_id ,
                'price_id'      => $row->price_id ,
                'food_id'       => $row->food_id ,
                'food'          => Food::fieldRows($foods),
                'restourant_id' => $row->restourant_id ,
                'restourant'    => Restourant::fieldRows( $restourants ),
                'comment'       => $row->comment ,
                'score'         => $row->score ,
                'created_at'    => strtotime($row->created_at) ,
                'updated_at'    => strtotime($row->updated_at) ,
        ];
    }

    public static function Score($price_id,$type='detail'){
        if( $type == 'order'){
            $score = Rating::where('order_id',$price_id)->sum('score');
            $count   = Rating::where('order_id',$price_id)->count();
            }else{
            $score = Rating::where('price_id',$price_id)->sum('score');
            $count   = Rating::where('price_id',$price_id)->count();
            }
		$data = [
			'score' => $score ? Lib::nb( $score / $count ,2) : 0,
			'rate'  => $score ? 'Y' : 'N'
		];
		return json_encode( $data );
    }
}
