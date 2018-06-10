<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Rating;
use App\Models\Price;
use App\Lib;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo '<pre>', print_r( $request->all()),'</pre>';
        $user = User::toUser( $request->input('token') );
        if( $request->input('ratings') ){
            foreach( $request->input('ratings') as $rate ){
                //echo '<p>Score = '. $rate['score'] .'</p>';
                $score = $rate['score'];
                $comment = $rate['comment'];
                $detail_id = $rate['detail_id'];
                $price_id  = $rate['price_id'];
                $price = Price::where('id', $price_id)->first();
                if( $price ){
                    $chk = Rating::where('user_id', $user->id)
                                ->where('order_id',$request->input('orderId') )
                                ->where('detail_id',$detail_id)
                                ->where('price_id',$price_id)
                                ->first();
                    $row = $chk ? $chk : new Rating;
                    $row->user_id   = $user->id;
                    $row->order_id  = $request->input('orderId');
                    $row->detail_id = $detail_id;
                    $row->price_id  = $price_id;
                    $row->food_id   = $price->food_id;
                    $row->restourant_id = $price->restourant_id;
                    $row->comment = $comment != '' ? $comment : '';
                    $row->score = $score != '' ? $score : 0;
                    if( !$row->save() ){
                        $data = [
                            'code' => 202,
                            'msg' => 'Error!!'
                        ];
                        break;
                    }
                }
            }
        }
        $data = [
            'code' => 200,
            'msg' => 'Success full'
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $rows = Rating::where('price_id',$id)->orderBy('id')->get();
       $rateData = [];
       if( $rows ){
           foreach( $rows as $row){
               $rateData[] = Rating::fieldRows( $row );
           }
           $data = [
               'code' => 200,
               'data' => $rateData
           ];
       }else{
           $data = [
               'code' => 202,
               'data' => []
           ];
       }
       return response()->json( $data );
       

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
