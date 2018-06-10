<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;
use App\Models\OrderDetail;
use App\Models\Tracking;
use App\Models\Attach;
use App\Lib;
use Auth;
use PDF;
use DB;
use Excel;
use PHPExcel;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->status = [ 'processing','waiting','shipment','collecting','finish' ];
    }
    public function index()
    {
        $start  = Req::exists('start') ? date('Y-m-d 00:00:00',strtotime( Req::input('start') )) : date('Y-m-01 00:00:00');
        $end    = Req::exists('end') ? date('Y-m-d 23:59:59',strtotime( Req::input('end') )) : date('Y-m-d H:i:s');
        $rows = $this->onQuery($start,$end)->paginate(120);

        $data = [
            'rows'          => $rows,
            '_breadcrumb'	=> 'Order Report',
            'x'             => 0,
            'node'          => [],
            'total'         => 0,
            'start'         => $start,
            'end'           => $end
        ];
        
        return view('backend.report.index',$data);
    }

    public function onQuery( $start , $end ){
        return DB::table('order_heads as head')
        ->join('order_details as detail','head.id','=','detail.order_id')
        ->select('head.id as head_id',
                'head.created_at as order_date',
                'head.*',
                'detail.id as detail_id',
                'detail.*')
        ->whereIn('head.status', $this->status )
        ->whereBetween('head.created_at',[$start,$end])
        ->orderBy('head.created_at');
    }

    public function export($type='',$file=''){
        $data = [];
        if( $type == 'order'){
            if( $file == 'pdf'){

            }
        }
        if( $type == 'sheet'){
            if( $file == 'pdf'){

            }
            if( $file == 'xls'){
                $data = json_decode( $this->xls() );
            }
        }
        return response()->json( $data );
    }

    public function orderPdf($id){

    }

    public function xls(){
        $start  = Req::exists('start') ? date('Y-m-d 00:00:00',strtotime( Req::input('start') )) : date('Y-m-01 00:00:00');
        $end    = Req::exists('end') ? date('Y-m-d 23:59:59',strtotime( Req::input('end') )) : date('Y-m-d H:i:s');
        $query  = $this->onQuery($start,$end)->get();
        $x             = 0;
        $node          = [];
        $total         = 0;
        $qty           = 0;
        $data           = [];
        if( $query ){
            $rows = $query;
            $xls 	= new PHPExcel();
            $excel 	= 'public/documents/order-report-from-'. date('d_m_Y',strtotime($start)) .'-To-'. date('d_m_Y',strtotime($end)) .'-'. time() .'.xlsx';
            include storage_path() . '/export-class/xls-header-a4-landscape.php';
			$subject 	= 	'ORDER REPORT';
            include storage_path() . '/export-class/xls-report.php';
            $data = [
                'code' => 200,
                'file' => asset( $excel )
            ];
        }else{ 
            $data = [
                'code' => 202,
                'file' => ''
            ];
        }
        return  json_encode( $data );
    }
}
