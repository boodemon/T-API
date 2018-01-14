<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lib;
use App\Models\Category;
use App\Models\Restourant;
use Auth;

class RestourantController extends Controller
{
    public function __construct(){
        $this->category_path = public_path().'/images/category/';
        $this->restourant_path = public_path() .'/images/restourant/';
        echo '<pre>',print_r( Auth::guard('web')->user() ). '</pre>';
    }

    public function index(){
        $row = Restourant::orderBy('name')->paginate(50);
        if($row){
            $res = [
                'result'    => 'successful',
                'data'      => $row
            ];
        }else{
            $res = [
                'result'    => 'error',
                'data'      => false,
            ];
        }
        return response()->json( $res );
    }

    public function edit($id){
        $row = Restourant::where('id',$id)->first();
        if( $row ){
            $res = [
                'result'    => 'successful',
                'data'      => $row,
            ];
        }else{
            $res = [
                'result'    => 'error',
                'data'      => false,
                'msg'       => 'Cannot found this Restourant. Please try again.'
            ];
        }
        return response()->json( $res );
    }

    public function store(Request $request ){
        $row = new Restourant;
        $row->restourant = $request->input('restourant');
        $row->contact = $request->input('contact');
        $row->tel = $request->input('tel');
        $row->active = $request->input('active') == '1' ? 'Y' : 'N';
        if( $row->save() ){
            $res = [
                'resule'    => 'successful',
                'data'      => $row
            ];
        }else{
            $res = [
                'result'    => 'error',
                'data'      => false,
                'msg'       => 'Error!! Cannot save this. Please try again.'
            ];
        }
        return response()->json( $res );
    }

}
