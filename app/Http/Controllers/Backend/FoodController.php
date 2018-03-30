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
    public function index()
    {
        $rows = Food::orderBy('food_name')->paginate(24);
        $data = [
            'rows'  => $rows,
            'group' => Category::queryJson() ,
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
        //$price = [];
        if( $request->input('restourant') ){
            foreach( $request->input('restourant') as $idx => $data ){
                $price = new Price;
                $price->food_id         = $food->id;
                $price->category_id     = $request->input('groups');
                $price->restourant_id   = $data;
                $price->price           = $request->input('unit-price.'. $data);
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
            //$price = [];
            @Price::where('food_id',$id)
                    ->whereNotIn( 'restourant_id', $request->input('restourant') )
                    ->delete();

            if( $request->input('restourant') ){
                foreach( $request->input('restourant') as $idx => $data ){
                    $cprice = Price::where('food_id',$id)
                                    ->where('restourant_id',$data)
                                    ->first();

                    $price = $cprice ? $cprice : new Price;
                    $price->food_id         = $food->id;
                    $price->category_id     = $request->input('groups');
                    $price->restourant_id   = $data;
                    $price->price           = $request->input('unit-price.'. $data);
                    $price->save();
                }
            }else{ 
                Price::where('food_id',$id)
                    ->delete();
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
        $rows = Restourant::where(\DB::raw("FIND_IN_SET($id, category_id)"),">",\DB::raw("'0'"))
                            ->orderBy('restourant')
                            ->get();
        $price = Price::where('food_id',$food_id)->get();
        $pres = [];
        $p = [];
        if($price){
            foreach($price as $pr){
                $res_id = $pr->restourant_id;
                $pres[$res_id] = [
                    'food_id'       => $pr->food_id,
                    'restourant_id' => $pr->restourant_id,
                    'category_id'   => $pr->category_id ,
                    'price'         => $pr->price
                ];
            }
        }
        $data = [
            'rows' => $rows,
            'price' => $pres
        ];
        return view('backend.food.food-price',$data);
    }

    public function price_list($food_id = 0){
        $price = Price::where('food_id',$food_id)->get();
        $data = [
            'price' => $price
        ];
        return view('backend.food.food-price-list',$data);
    }
}
