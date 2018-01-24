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
        $rows = Restourant::orderBy('restourant')->paginate(50);
        $data = [];
        if( $rows ){
            foreach( $rows as $row ){
                $data[] = [
                    'id'            => $row->id,
                    'groups'        => $this->groupName( @json_decode($row->category_id) ),
                    'restourant'    => $row->restourant,
                    'contact'       => $row->contact ,
                    'tel'           => $row->tel,
                    'image'         => $row->image,
                    'active'        => $row->active,
                    'created'       => $row->created_at,
                    'updated'       => $row->updated_at
                ];
            }
        }
        if($row){
            $res = [
                'code'      => 200,
                'result'    => 'successful',
                'data'      => $data
            ];
        }else{
            $res = [
                'code'      => 204,
                'result'    => 'error',
                'data'      => false,
            ];
        }
        return response()->json( $res );
    }

    public function groupName($arr = []){
        $data = [];
        $group = Category::queryJson();
        if( is_array($arr) || is_object($arr) ){
            foreach( $arr as $dx => $ar ){
                $data[] = $group[$ar]['name'];
            }
        }
        return $data ? implode(', ',$data) : '';
    }

    public function edit($id){
        $row = Restourant::where('id',$id)->first();
        if( $row ){
            $data = [
                'id'        => $row->id,
                'groups'    => @json_decode( $row->category_id ),
                'restourant'    => $row->restourant,
                'contact'       => $row->contact ,
                'tel'           => $row->tel,
                'image'         => $row->image,
                'active'        => $row->active,
                'created'       => $row->created_at,
                'updated'       => $row->updated_at
            ];
            $res = [
                'code'      => 200,
                'result'    => 'successful',
                'data'      => $data,
            ];
        }else{
            $res = [
                'result'    => 'error',
                'code'      => 204,
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
                'data'      => $row,
                'code'      => 200
            ];
        }else{
            $res = [
                'result'    => 'error',
                'data'      => false,
                'msg'       => 'Error!! Cannot save this. Please try again.',
                'code'      => 204
            ];
        }
        return response()->json( $res );
    }

    public function update(Request $request , $id ){
        //echo '<pre>',print_r( $request->all() ),'</pre>';
        $row = Restourant::where('id',$id)->first();
        if( $row ){
                $row->restourant    = $request->input('restourant');
                $row->contact       = $request->input('contact');
                $row->tel           = $request->input('tel');
                $row->category_id   = json_encode( $request->input('groups') );
                $row->active        = $request->input('active') == '1' ? 'Y' : 'N';
                if( $request->input('image')){
                    $filename = time() . Lib::ext(  $request->input('image.filename') );
                    Image::make(base64_decode($request->input('image.value')))->resize(800,120)->save($this->restourant_path . $filename);
                    File::delete( $this->restourant_path . $row->image );
                    $row->image = $filename;
                }
                if( $row->save() ){
                    $res = [
                        'resule'    => 'successful',
                        'data'      => $row,
                        'code'      => 200
                    ];
                }else{
                    $res = [
                        'result'    => 'error',
                        'data'      => false,
                        'msg'       => 'Error!! Cannot save this. Please try again.',
                        'code'      => 204
                    ];
                }
        }else{
            $res = [
                'result'    => 'error',
                'data'      => false,
                'msg'       => 'Error!! Restourant not found. Please try again.',
                'code'      => 204
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
                    'code'      => 200
                ];
            }else{
                $result = [
                    'result'    => 'error',
                    'msg'       => 'เกิดข้อผิดพลาดจากระบบไม่สามารถทำการลบข้อมูลได้ โปรดลองใหม่ภายหลัง',
                    'code'      =>  204
                ];
    
            }
        return Response()->json($result);
    }
}
