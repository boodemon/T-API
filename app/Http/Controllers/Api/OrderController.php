<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;
use App\Models\OrderDetail;
use App\User;
use Request as Req;
class OrderController extends Controller
{
    public function index(){
        $user = User::toUser( Req::input('token') );
    }
    public function store(Request $request){
        $data = [];
        $inputHead = @json_decode( $request->input('onHead') );
        $row = new OrderHead;
        $row->user_id   = $request->input('onHead.userId'); //$inputHead->;
        $row->jobname   = $request->input('onHead.jobName'); //$inputHead->;
        $row->address   = $request->input('onHead.jobAddress'); //$inputHead->;
        //$row->jobdate = date('Y-m-d H:i:00', strtotime( $inputHead->jobTime .' ' . $inputHead->jobDate) );
        $row->jobdate   = date('Y-m-d H:i:00', strtotime( $request->input('onHead.jobDate')  .' ' . $request->input('onHead.jobTime') ) );
        $row->remark    = $request->input('onHead.jobRemark'); //$inputHead->;
        $row->save();
        $price = 0;
        $onList =  $request->input('onList');
        if( $onList ){
            foreach( $onList as $idx=>$input){
                $item = new OrderDetail;
                $item->order_id         = $row->id;
                $item->user_id          = $request->input('onList.' . $idx . '.userId');
                $item->category_id      = $request->input('onList.' . $idx . '.category_id');
                $item->price_id         = $request->input('onList.' . $idx . '.price_id');
                $item->food_id          = $request->input('onList.' . $idx . '.food_id');
                $item->restourant_id    = $request->input('onList.' . $idx . '.restourant_id');
                $item->qty              = $request->input('onList.' . $idx . '.quantity');
                $item->per_price        = $request->input('onList.' . $idx . '.price');
                $item->total_price      = $request->input('onList.' . $idx . '.price') * $request->input('onList.' . $idx . '.quantity');
                $item->remark           = $request->input('onList.' . $idx . '.remark');
                $item->save();
                $price += $request->input('onList.' . $idx . '.price') * $request->input('onList.' . $idx . '.quantity');
            }
            $row->price    = $price;
            $row->save();

        }
        if( $row ){
            $data = [
                'code' => 200,
                'result' => 'success ful'
            ];
        }else{
            $data = [
                'code' => 202,
                'result' => 'error'
            ];
        }

        return response()->json( $data );
    }
}
