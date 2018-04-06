<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Content;

class ContentController extends Controller
{
    public function aboutus(){
        $row = Content::where('content_type','aboutus')->first();
        if( $row ){
            $cdata = $this->contentField($row);
            $data = [
                'code' => 200,
                'data' => $cdata
            ];
        }else{ 
            $data = [
                'code' => 202,
                'data' => false
            ];
        }
        return response()->json($data);
    }

    public function contentField($row){
        return [
            'id'            => $row->id ,
            'subject'       => $row->subject ,
            'detail'        => $row->detail ,
            'content_type'  => $row->content_type ,
            'created_at'    =>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at'    =>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) ),
        ];
    }
}
