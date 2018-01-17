<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lib;
use App\Models\Category;
use App\Models\Restourant;
use Auth;
use Image;
use File;

class RestourantController extends Controller
{
    public function __construct(){
        $this->category_path = public_path().'/images/category/';
        $this->restourant_path = public_path() .'/images/restourant/';
        //echo '<pre>Auth user : ',print_r( Auth::guard('web')->user() ). '</pre>';
    }

    public function index(){
        $row = Restourant::orderBy('restourant')->paginate(50);
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
        if( $request->input('image')){
            $filename = time() . Lib::ext(  $request->input('image.filename') );
            Image::make(base64_decode($request->input('image.value')))->resize(800,120)->save($this->restourant_path . $filename);
            $row->image = $filename;
        }      

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

    public function update(Request $request , $id ){
        $row = Restourant::where('id',$id)->first();
        if( $row ){
                $row->restourant = $request->input('restourant');
                $row->contact = $request->input('contact');
                $row->tel = $request->input('tel');
                $row->active = $request->input('active') == '1' ? 'Y' : 'N';
                if( $request->input('image')){
                    $filename = time() . Lib::ext(  $request->input('image.filename') );
                    Image::make(base64_decode($request->input('image.value')))->resize(800,120)->save($this->restourant_path . $filename);
                    File::delete( $this->restourant_path . $row->image );
                    $row->image = $filename;
                }      

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
        }else{
            $res = [
                'result'    => 'error',
                'data'      => false,
                'msg'       => 'Error!! Restourant not found. Please try again.'
            ];
        }
        return response()->json( $res );
    }

    public function destroy($id)
    {
        $ids = explode('-',$id);
 
            if( Restourant::whereIn('id',$ids)->delete() ){
                $result = [
                    'result'    => 'successful',
                ];
            }else{
                $result = [
                    'result'    => 'error',
                    'msg'       => 'เกิดข้อผิดพลาดจากระบบไม่สามารถทำการลบข้อมูลได้ โปรดลองใหม่ภายหลัง'
                ];
    
            }
        return Response()->json($result);
    }
}
