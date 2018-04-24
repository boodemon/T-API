<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;
use App\Models\OrderDetail;
use App\User;
use App\Lib;
use Request as Req;
use App\Models\Restourant;
use App\Models\Food;
use App\Models\Tracking;
use App\Models\Message;
use App\Models\Bank;
use App\Models\Attach;
use Image;
class OrderController extends Controller
{
    public function __construct(){
        $this->path = public_path() . '/images/attach/';
    }
    public function index(){
        $user = User::toUser( Req::input('token') );
        $rows = OrderHead::where('user_id',$user->id);
        if( Req::exists('status') ){
            if( Req::input('status') == 'processing'){
                $rows = $rows->where('status','!=','finish');
            }else{ 
                $rows = $rows->where('status', Req::input('status') );
            }
        }
        if( Req::exists('onStart') ){
            $start  = date('Y-m-d 00:00:00', strtotime( Req::input('onStart') ) );
            $end    = date('Y-m-d 23:59:59', strtotime( Req::input('onEnd') ) );
            $rows = $rows->whereBetween('created_at',[$start,$end]);
        }
        
        $jdata = [];
        $rows = $rows->orderBy('created_at')->get();
        if( $rows ){
            foreach( $rows as $row ){
                $jdata[] = $this->headField($row);
            }
        }
        $data = [
            'code' => 200,
            'data' => $jdata
        ];
        return response()->json( $data );
    }

    public function show($id){
        $head = OrderHead::where('id',$id)->first();
        $hdata = [];
        $ddata = [];
        if($head){
            $hdata = $this->headField($head);
            $details = OrderDetail::where('order_id',$id)->orderBy('id')->get();
            $qty = 0;
            $total = 0;
            if( $details ){
                foreach( $details as $detail ){
                    $ddata[] = $this->detailField( $detail );
                    $qty += $detail->qty;
                    $total += $detail->per_price * $detail->qty;
                }
            }
            $hdata['qty'] = $qty;
            $data = [
                'code' => 200,
                'head' => $hdata,
                'details' => $ddata
            ];
        }else{
            $data = [
                'code'      => 202,
                'head'      => [],
                'details'   => []
            ];
        }
        return response()->json($data);
    }
    public function store(Request $request){
        $data = [];
        $inputHead = @json_decode( $request->input('onHead') );
        $row = new OrderHead;
        $row->user_id   = $request->input('onHead.userId');
        $row->jobname   = $request->input('onHead.jobName');
        $row->address   = $request->input('onHead.jobAddress');
        $row->jobdate   = date('Y-m-d H:i:00', strtotime( $request->input('onHead.jobDate')  .' ' . $request->input('onHead.jobTime') ) );
        $row->remark    = $request->input('onHead.jobRemark');
        $row->status    = 'new';
        $row->save();
        $price = 0;
        $onList =  $request->input('onList');
        if( $onList ){
            foreach( $onList as $idx=>$input){
                $item = new OrderDetail;
                $item->order_id         = $row->id;
                $item->user_id          = $request->input('onList.' . $idx . '.userId');
                $item->category_id      = $request->input('onList.' . $idx . '.category_id');
                $item->price_id         = $request->input('onList.' . $idx . '.price_id');
                $item->food_id          = $request->input('onList.' . $idx . '.food_id');
                $item->restourant_id    = $request->input('onList.' . $idx . '.restourant_id');
                $item->qty              = $request->input('onList.' . $idx . '.quantity');
                $item->per_price        = $request->input('onList.' . $idx . '.price');
                $item->total_price      = $request->input('onList.' . $idx . '.price') * $request->input('onList.' . $idx . '.quantity');
                $item->remark           = $request->input('onList.' . $idx . '.remark');
                $item->save();
                $price += $request->input('onList.' . $idx . '.price') * $request->input('onList.' . $idx . '.quantity');
            }
            $row->price    = $price;
            $row->save();

        }
        if( $row ){
            $track = new Tracking;
            $track->user_id         =  $row->user_id ;
            $track->admin_id        =  0 ;
            $track->order_id        =  $row->id;
            $track->tracking_name   =  'ส่งคำสั่งซื้อ สถานะ รอชำระเงิน';
            $track->save();
            $data = [
                'code' => 200,
                'result' => 'success ful'
            ];
        }else{
            $data = [
                'code' => 202,
                'result' => 'error'
            ];
        }

        return response()->json( $data );
    }
    
    public function tracking($order_id){
        $rows = Tracking::where('order_id',$order_id)->orderBy('created_at','asc')->get();
        $tdata = [];
        if( $rows ){
            foreach( $rows as $row ){
                $tdata[] = $this->trackField( $row );
            }
        }
        return $tdata;

    }

    public function headField($row){
        return [
            'id'         =>  $row->id ,
            'code'       =>  sprintf('%05d',$row->id),
            'user_id'    =>  $row->user_id ,
            'jobname'    =>  $row->jobname ,
            'address'    =>  $row->address ,
            'jobdate'    =>  date( 'd M Y', strtotime($row->jobdate) ) ,
            'jobtime'    =>  date('H:i', strtotime( $row->jobdate ) ) ,
            'remark'     =>  $row->remark ,
            'price'      =>  $row->price ,
            'charge'     =>  $row->charge ,
            'tax'        =>  $row->tax ,
            'status'     =>  $row->status ,
            'created_at' =>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at' =>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) ),
            'tracking'   =>  $this->tracking( $row->id ),
        ];
    }
    public function detailField($row){
        return [
            'id'            =>  $row->id ,
            'order_id'      =>  $row->order_id ,
            'user_id'       =>  $row->user_id ,
            'price_id'      =>  $row->price_id ,
            'category_id'   =>  $row->category_id ,
            'food_id'       =>  $row->food_id ,
            'food_name'     =>  Food::field($row->food_id),
            'restourant_id' =>  $row->restourant_id ,
            'restourant'    =>  Restourant::field( $row->restourant_id ) ,
            'qty'           =>  $row->qty ,
            'per_price'     =>  $row->per_price ,
            'total_price'   =>  $row->total_price ,
            'remark'        =>  $row->remark ,
            'created_at'    =>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at'    =>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) )
        ];
    }

    public function trackField($row){
        return [
            'id'            =>  $row->id ,
            'user_id'       =>  $row->user_id ,
            'admin_id'      =>  $row->admin_id ,
            'order_id'      =>  $row->order_id ,
            'tracking_name' =>  $row->tracking_name ,
            'attach'        =>  $this->attach( $row->id ),
            'created_at'    =>  date('Y-m-d H:i:s', strtotime( $row->created_at ) ) ,
            'updated_at'    =>  date('Y-m-d H:i:s', strtotime( $row->updated_at ) ),
        ];
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

    public function confirmation(Request $request){
        $user = User::toUser( $request->input('token') );
        $subject = $request->input('subject');
        $message = $request->input('message');
        $bank = Bank::where('id',$request->input('bank'))->first();

        $track = new Tracking;
        $track->user_id = $user->id;
        $track->order_id = $request->input('ref_id');
        $track->tracking_name = '<h4>' . $request->input('subject') .'</h4>'
                                .'<p>ชื่อบัญชี <strong>'. $bank->bank_account .'</strong></p>'
                                .'<p> เลขที่ <strong>'. $bank->bank_id  .'</strong> บัญชี : <strong> '. $bank->bank_type  .' </strong></p>'
                                .'<p> ธนาคาร : <strong>'. $bank->bank_name  .'</strong></p>'
                                .'<p>สาขา : <strong>'. $bank->bank_branch  .'</strong></p>'
                                .'<p>'. $message .'</p>';
        $track->save();
        if( $request->input('attach') ){
            $filename = Lib::uploadfrombase64( $request->input('attach'), $this->path );

            $att = new Attach;
            $att->attach_link = $filename;
            $att->ref_id      = $track->id;
            $att->attach_type = 'tracking';
            $att->save();
            $message .= '<p><strong>Attach file</strong></p>'
                        .'<p><img src="'. asset('public/images/attach/'. $filename) .'" />';
        }
        Message::sender(1,$user->id,$subject,$message);
        OrderHead::where('id',$request->input('ref_id') )->update(['status'=>'confirmation']);

        $data = [
            'code' => 200,
        ];
        return response()->json( $data );
    }
}
