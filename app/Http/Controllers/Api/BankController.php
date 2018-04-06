<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\OrderHead;
use App\Models\OrderDetail;
use App\User;


class BankController extends Controller
{
    public function index(){
        $user = User::toUser(Req::input('token'));
        $rows = Bank::where('active','Y')->orderBy('bank_sort')->orderBy('bank_name')->get();
        $orders = OrderHead::where('user_id',$user->id)->where('status','new')->orderBy('id')->get();

        if( $rows ){
            $jdata = [];
            $hdata = [];
            if( $orders ){
                foreach($orders as $order){
                    $hdata[] = $this->orderHeadField( $order );
                }   
            }
            foreach( $rows as $row ){
                $jdata[] = $this->field( $row );
            }
            $data = [
                'code' => 200,
                'data' => $jdata,
            ];
        }else{
            $data = [
                'code' => 202,
                'data' => false
            ];
        }
        return response()->json($data);
    }

    public function field( $row ){
        return [
            'id'            =>  $row->id ,
            'bank_image'    =>  $row->bank_image ,
            'bank_name'     =>  $row->bank_name ,
            'bank_branch'   =>  $row->bank_branch ,
            'bank_type'     =>  $row->bank_type ,
            'bank_id'       =>  $row->bank_id ,
            'bank_account'  =>  $row->bank_account ,
            'bank_sort'     =>  $row->bank_sort ,
            'active'        =>  $row->active ,
            'created_at'    =>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at'    =>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) ),
        ];
    }

    public function orderHeadField( $row ){
        return [
            'id'            =>  $row->id ,
            'user_id'       =>  $row->user_id ,
            'jobname'       =>  $row->jobname ,
            'address'       =>  $row->address ,
            'jobdate'       =>  $row->jobdate ,
            'remark'        =>  $row->remark ,
            'price'         =>  $row->price ,
            'charge'        =>  $row->charge ,
            'tax'           =>  $row->tax ,
            'status'        =>  $row->status ,
            'created_at'    =>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at'    =>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) ),
                ];
    }
}
