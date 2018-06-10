<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restourant;
use App\Models\Food;
use App\Models\Price;
use Image;
use File;
use DB;
use Lib;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->food_path = public_path() .'/images/foods/';
    }
    public function index(Request $request)
    {
        $category = 'ALL';
        $rows = Food::orderBy('food_name');
        if( $request->exists('keywords') ){
            $keywords = $request->input('keywords');
            if( !empty( $keywords ) ){
                $rows = $rows->where( function($query) use($keywords){
                    $keys = explode(' ', $keywords);
                    foreach($keys as $no => $key){
                        $query->where('food_name','like','%'.$key .'%');
                    }
                });
            }
        }
        if( $request->exists('category') &&  !empty( $request->input('category') )){
            $rows = $rows->where('category_id', $request->input('category'));
            $category = Category::field( $request->input('category') );
        }
            $rows = $rows->paginate(24);
        $data = [
            'rows'  => $rows,
            'group' => Category::queryJson() ,
            'category' => $category,
            '_breadcrumb'	=> 'Food'
        ];
        return view('backend.food.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'id'            => 0,
            'action'        => 'foods/food',
            '_method'       => 'POST',
            'row'           => false,
            '_breadcrumb'	=> 'Food',
            'selected'      => 0
        ];
        return view('backend.food.food-form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $food = new Food;
        $food->food_name = $request->input('name');
        $food->kcal = $request->input('kcal');
        if( $request->hasFile('image')){
            $file = $request->file('image');
				$filename = time() . '.jpg';// Lib::encodelink( $file->getClientOriginalName() );
                Image::make( $file )
                        ->encode('jpg', 75)
                        ->resize(800,400)
                        ->save($this->food_path . $filename);
                $food->food_image = $filename;
        }
        $food->active = $request->has('active') ? 'Y' : 'N';
        $food->category_id = $request->input('groups');
        $food->save();
        if( $request->exists('price.id') ){
            foreach( $request->input('price.id') as  $idx => $data ){
                $restourant_id  = $request->input('price.restourant_id.'. $idx);
                $uprice          = $request->input('price.price.'. $idx);                    
                $cprice = Price::where('food_id',$food->id)
                                ->where('restourant_id',$restourant_id)
                                ->first();

                $price = $cprice ? $cprice : new Price;
                $price->food_id         = $food->id;
                $price->category_id     = $request->input('groups');
                $price->restourant_id   = $restourant_id;
                $price->price           = $uprice;
                $price->save();
                
            }
        }
        return redirect('foods/food');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Food::where('id',$id)->first();
        if( !$row ) return abort(404);
        $data = [
            'id'        => $id,
            'action'    => 'foods/food/'. $id,
            '_method'   => 'PUT',
            'row'       => $row,
            '_breadcrumb'	=> 'Food',
            'selected'    => $row->category_id
        ];
        return view('backend.food.food-form',$data);    
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
        //echo '<pre>',print_r( $request->all() ),'</pre>';
        
        $food = Food::where('id',$id)->first();
        if( $food ){
            $food->food_name = $request->input('name');
            $food->kcal = $request->input('kcal');
            if( $request->hasFile('image')){
                if( file_exists( $this->food_path . $food->food_image ) )
                    @File::delete( $this->food_path . $food->food_image );

                $file = $request->file('image');
                    $filename = time() . '.jpg';
                    Image::make( $file )
                            ->encode('jpg', 75)
                            ->resize(800,400)
                            ->save($this->food_path . $filename);
                    $food->food_image = $filename;
            }
            $food->active       = $request->has('active') ? 'Y' : 'N';
            $food->category_id  = $request->input('groups');
            $food->save();

            if( $request->exists('price.id') ){
                foreach( $request->input('price.id') as  $idx => $data ){
                    $restourant_id  = $request->input('price.restourant_id.'. $idx);
                    $uprice          = $request->input('price.price.'. $idx);                    
                    $cprice = Price::where('food_id',$id)
                                    ->where('restourant_id',$restourant_id)
                                    ->first();

                    $price = $cprice ? $cprice : new Price;
                    $price->food_id         = $food->id;
                    $price->category_id     = $request->input('groups');
                    $price->restourant_id   = $restourant_id;
                    $price->price           = $uprice;
                    $price->save();
                    
                }
            }
        }
        return redirect('foods/food');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delImg($id){
        if($id){
            foreach($id as $i => $d){
                @File::delete($this->food_path . Food::field($d,'food_image') );
            }
        }
    }
    public function destroy($id)
    {
        $ids = explode('-',$id);
        $this->delImg($ids);
        Price::whereIn('food_id',$ids)->delete();
        if( Food::whereIn('id',$ids)->delete() ){
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

    public function price($id = 0,$food_id = 0){

        $price = Price::where('food_id',$food_id)->get();
        $pres = [];
        $p = [];
        if($price){
            foreach($price as $pr){
                $res_id = $pr->restourant_id;
                $rest   = Restourant::where('id',$res_id)->first();
                $pres[] = [
                    'id'            => $pr->id,
                    'food_id'       => $pr->food_id,
                    'restourant_id' => $pr->restourant_id,
                    'category_id'   => $pr->category_id ,
                    'price'         => $pr->price,
                    'restourant'    => $rest->restourant
                ];
            }
        }
        $data = [
            'price' => @json_decode( @json_encode( $pres ) )
        ];
        return view('backend.food.food-price',$data);
    }

    public function restourant(Request $request,$id = 0){
        $terms = $request->input('term');
        //echo '<pre>', print_r( $request->all() ),'</pre> id => ' . $id .' | <br/>';
        $autoData = [];
        $rows = Restourant::where(\DB::raw("FIND_IN_SET($id, category_id)"),">",\DB::raw("'0'"))
                            ->where( function($query) use ($terms){
                                $terms = explode(' ', $terms);
                                foreach( $terms as $no => $term ){
                                    //echo 'term => ' . $term .'<br/>';
                                    $query->where('restourant','like','%'. $term .'%');
                                }
                            })
                            ->orderBy('restourant')
                            ->skip(0)->take(24)->get();
        if( $rows ){
            foreach( $rows as $row ){
                $autoData[] = [
                    'value'         => $row->restourant,
                    'label'         => $row->restourant,
                    'id'            => $row->id,
                    'groups'        => Category::groupName( @json_decode($row->category_id) ),
                    'restourant'    => $row->restourant,
                    'contact'       => $row->contact ,
                    'tel'           => $row->tel,
                    'image'         => $row->image,
                    'thumb'         => Lib::exsImg( 'public/images/restourant' , $row->image ),
                    'active'        => $row->active,
                    'created'       => $row->created_at,
                    'updated'       => $row->updated_at
                            
                ];
            }
        }

        return response()->json($autoData);
    }

    public function price_list($food_id = 0){
        $price = Price::where('food_id',$food_id)->get();
        $data = [
            'price' => $price
        ];
        return view('backend.food.food-price-list',$data);
    }

    public function priceRemove($id = 0){
        Price::where('id', $id)->delete();
    }
}
