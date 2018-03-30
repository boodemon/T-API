<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Bank;

class BankController extends Controller
{
    public function index(){
        $rows = Bank::where('active','Y')->orderBy('bank_sort')->orderBy('bank_name')->get();
        if( $rows ){
            $jdata = [];
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
}
