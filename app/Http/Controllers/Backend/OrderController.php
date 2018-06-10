<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;
use App\Models\OrderDetail;
use App\Models\Tracking;
use App\Models\Attach;
use App\Lib;
use Auth;
use PDF;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct(){
        $this->user    = Auth::guard('admin')->user();
        $this->pdf_path = 'public/documents/order/';
        $this->status = Lib::statusValue();
        $this->field = ['id' => 'ORDER NO', 'jobname' => 'JOB NAME'];
    }

    public function index(Request $request)
    {
        $rows = OrderHead::Active();
        if( $request->exists('status') && !empty( $request->input('status') ) )
            $rows = $rows->where('status',$request->input('status') );
        if( $request->exists('keywords') && !empty( $request->input('keywords') ) ){
            $keywords   = $request->input('keywords');
            $field      = $request->input('field');
            if( $field == 'id'){
                $keywords = str_replace('#','',$keywords);
                //$keywords = intval( $keywords);
            }
            $rows = $rows->where(function($query) use($keywords,$field){

                    $keys = explode(' ', $keywords);

                    foreach( $keys as $no => $key ){
                        if( $field == 'id' ){
                            $key = intval( $key );
                            if(!empty( $key ))
                            if( $no == 0 ){
                                $query->where($field,'like','%' . $key .'%');
                            }else{
                                $query->orWhere($field,'like','%' . $key .'%');            
                            }
                        }else{
                            $query->where($field,'like','%' . $key .'%');

                        }
                        //echo 'key = ' . $key .'<br/>';
                    }
            });
        }
        $rows = $rows->orderBy('updated_at','DESC')->paginate(50);
        $data = [
            'rows'          => $rows,
            'status'        => $this->status,
            'field'         => $this->field,
            '_breadcrumb'	=> 'Order',

        ];
        return view('backend.order.index',$data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $head = OrderHead::where('id',$id)->first();
        if( $head ){
            $data = [
                'data' => OrderHead::fieldRows($head),
                'code' => 200
            ];
        }else{ 
            $data = [
                'data' => [],
                'code' => 202
            ];
        }
        return response()->json( $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $head = OrderHead::where('id',$id)->first();
        $details = OrderDetail::where('order_id',$id)->get();
        $data = [
            'head'      => $head,
            'details'   => $details,
            'no'        => 1,
            'id'        => $id,
            '_breadcrumb'	=> ['<a href="'. url('order') .'">Order</a>','Order Detail'],
        ];
        return view('backend.order.table',$data);
    }

    public function prints($id)
    {
        $head = OrderHead::where('id',$id)->first();
        $details = OrderDetail::where('order_id',$id)->get();
        $data = [
            'head'      => $head,
            'details'   => $details,
            'no'        => 1,
            'id'        => $id,
            'action'    => 'print'
        ];
        return view('backend.order.print-order',$data);
    }

    public function export($id)
    {
        $head = OrderHead::where('id',$id)->first();
        $details = OrderDetail::where('order_id',$id)->get();

        $data = [
            'head'      => $head,
            'details'   => $details,
            'no'        => 1,
            'id'        => $id,
            'action'    => 'export'
        ];
        $filename =  'Order-'. (sprintf( '%05d',$head->id )) .'.pdf';
        $name = Lib::filename( 'public/documents/order/' , $filename ); 
        
        $pdf = PDF::loadView('backend.order.print-order' , $data );
        return $pdf->download( $name );
        
        //return view('backend.order.print-order',$data);
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
        $head = OrderHead::where('id',$id )->first();
        $head->status   = $request->input('status');
        $head->save();

        $track = new Tracking;
        $track->admin_id = Auth::guard('admin')->user()->id;
        $track->order_id = $id;
        $track->tracking_name = $request->input('message');
        $track->save();

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
 
            if( OrderHead::whereIn('id',$ids)->update(['status' => 'cancelled']) ){
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
    public function attach($ref_id = 0){
        $rows = Attach::where('ref_id',$ref_id)->get();
        $adata = [];
        if($rows){
            foreach( $rows as $row ){
                $adata = Attach::row($row);
            }
        }
        return $adata;
    }
    public function tracking($id = 0){
        $rows = Tracking::where('order_id',$id)->orderBy('created_at','desc')->get();
        $tdata = [];
        if( $rows ){
            foreach( $rows as $row ){
                $tdata[] = Tracking::fieldRows( $row, $this->attach($row->id) );
            }
        }
        $data = [
            'data' => $tdata,
            'orderId' => sprintf('%05d',$id)
        ];
        return response()->json($data);
    }
}
