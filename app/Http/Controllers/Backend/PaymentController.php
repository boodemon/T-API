<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Bank;
use Image;
use Auth;
use File;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->bank_path = public_path() .'/images/bank/';
    }
    public function index()
    {
        $rows = Bank::active()->orderBy('bank_sort')->orderBy('bank_name')->paginate(50);
        $data = [
            'rows'          => $rows,
            '_breadcrumb'	=> 'Payments'
        ];
        return view('backend.payment.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $row = new Bank;
        $row->bank_name     = $request->input('bank_name');
        $row->bank_branch   = $request->input('bank_branch');
        $row->bank_type     = $request->input('bank_type');
        $row->bank_id       = $request->input('bank_id');
        $row->bank_account  = $request->input('bank_account');
        $row->bank_sort     = $request->input('bank_sort');

        $row->active    = $request->has('active') ? 'Y' : 'N';
        if( $request->hasFile('image')){
            $file = $request->file('image');
				$filename = time() . '.jpg';// Lib::encodelink( $file->getClientOriginalName() );
                Image::make( $file )
                        ->encode('jpg', 75)
                        ->resize(200,200)
                        ->save($this->bank_path . $filename);
                echo 'upload file';
                $row->bank_image = $filename;
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
        //return response()->json( $res );
        return redirect()->back(); 
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
        $row = Bank::where('id',$id)->first();
        if( $row ){

            $res = [
                'code'      => 200,
                'result'    => 'successful',
                'data'      => $row,
            ];
        }else{
            $res = [
                'result'    => 'error',
                'code'      => 204,
                'data'      => false,
                'msg'       => 'Cannot found this Payment. Please try again.'
            ];
        }
        return response()->json( $res );
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
        $row = Bank::where('id',$id)->first();
        if( $row ){
                $row->bank_name     = $request->input('bank_name');
                $row->bank_branch   = $request->input('bank_branch');
                $row->bank_type     = $request->input('bank_type');
                $row->bank_id       = $request->input('bank_id');
                $row->bank_account  = $request->input('bank_account');
                $row->bank_sort     = $request->input('bank_sort');
                $row->active        = $request->has('active') ? 'Y' : 'N';
                if( $request->hasFile('image') ){
                    $filename = time() . '.jpg'; // Lib::encodelink( $file->getClientOriginalName() );
                    $file = $request->file('image');
                        Image::make( $file->getRealPath() )
                            ->encode('jpg', 75)
                            ->resize(200,200)
                            ->save($this->bank_path . $filename);
                        @File::delete( $this->bank_path . $row->bank_image );
                        $row->bank_image = $filename;
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
                'msg'       => 'Error!! Payment not found. Please try again.',
                'code'      => 204
            ];
        }
        //return response()->json( $res );
        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = explode('-',$id);
 
            if( Bank::whereIn('id',$ids)->update(['active' =>'D']) ){
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
