<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Category;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lib;
use Image;
use File;

class CategoryController extends Controller
{
    public function __construct(){
        $this->path = public_path() . '/images/category/';
    }

    public function index(){
        $rows = Category::orderBy('category_sort')
                        ->orderBy('name')
                        ->paginate(25);
        $data = [
            'rows' => $rows,
            'img_path' => $this->path,
            '_breadcrumb'	=> 'Category'
        ];
        return view('backend.category.index',$data);
    }

    public function store(Request $request){
        //echo '<pre>', print_r( $request->all() ) ,'</pre>';
        $row = new Category;
        $row->name = $request->input('name');
        $row->category_sort = $request->input('category_sort');
        $row->active = $request->has('active') ? 'Y':'N';
        if( $request->hasFile('image')){
            $file = $request->file('image');
				$filename = time() . '.jpg';// Lib::encodelink( $file->getClientOriginalName() );
                Image::make( $file )
                        ->encode('jpg', 75)
                        ->resize(800,400)
                        ->save($this->path . $filename);
                //echo 'upload file';
                $row->image = $filename;
		}
        if( $row->save() ){
            $res = [
                'result' => 'successful',
                'code'   => 200
            ];
        }else{
            $res = [
                'result' => 'error',
                'msg'    => 'Cannot Save this category. Please try again.',
                'code'   => 204
            ];
        }
       return redirect()->back();//response()->json( $res );
    }

    public function edit($id){
        $row = Category::where('id',$id)->first();
        if( $row ){
            $res = [
                'result'    => 'successful',
                'data'      => $row,
                'code'      => 200
            ];
        }else{ 
            $res = [
                'result'    => 'error',
                'data'      => false,
                'msg'       => 'Category not found!!',
                'code'      => 204
            ];
        }
        return response()->json( $res);
    }

    public function update( Request $request ,$id ){
       
        //echo '<pre>', print_r( $request->all() ) ,'</pre>';
        $row = Category::where('id',$id)->first();
        if( $row ){
            $row->name = $request->input('name');
            $row->category_sort = $request->input('category_sort');
            $row->active = $request->has('active') ? 'Y' : 'N';
            if( $request->hasFile('image') ){
                $filename = time() . '.jpg';// Lib::encodelink( $file->getClientOriginalName() );
                $file = $request->file('image');
                //echo '<pre>', print_r( $file ), print_r( $request->file('image') ) ,'</pre>';
                     Image::make( $file->getRealPath() )
                        ->encode('jpg', 75)
                        ->resize(800,400)
                        ->save($this->path . $filename);
                    
                    //@File::delete( $this->path . $row->image );
                    $row->image = $filename;
            }
            if( $row->save() ){
                $res = [
                    'result' => 'successful',
                    'code'   => 200
                ];
            }else{
                $res = [
                    'result' => 'error',
                    'msg'    => 'Cannot update this category. Please try again.',
                    'code'   => 204
                ];
            }
        }else{
                $res = [
                    'result' => 'error',
                    'msg'    => 'Category not found. Please try again .',
                    'code'   => 204
                ];
        }
       //echo response()->json( $res );
       return redirect()->back(); 
    }
    public function destroy($id)
    {
        $ids = explode('-',$id);
 
            if( Category::whereIn('id',$ids)->delete() ){
                $result = [
                    'result'    => 'successful',
                    'code'      => 200
                ];
            }else{
                $result = [
                    'result'    => 'error',
                    'msg'       => 'เกิดข้อผิดพลาดจากระบบไม่สามารถทำการลบข้อมูลได้ โปรดลองใหม่ภายหลัง',
                    'code'      => 204
                ];
    
            }
        return Response()->json($result);
    }
}
