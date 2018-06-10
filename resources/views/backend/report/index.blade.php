@extends('backend.layouts.template')
@section('stylesheet')
    <link href="{{ asset('public/lib/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
@endsection
@section('content')
<div class="card">
      <div class="card-header">
        <i class="fa fa-user"></i> Food data Filter on 
            <strong>{{ date('M d, Y', strtotime($start) ) }} </strong> To 
            <strong>{{ date('M d, Y', strtotime($end) ) }} </strong>
        <div class="pull-right">
            <button type="button" class="btn btn-sm btn-outline-primary btn-filter"><i class="fa fa-filter"></i> FILTER</button>
            <button type="button" class="btn btn-sm btn-outline-success btn-exporter-xls"><i class="fa fa-file-excel-o"></i> EXPORT XLS</button>
            <!--
            <button type="button" class="btn btn-sm btn-outline-danger btn-exporter-pdf"><i class="fa fa-file-pdf-o"></i> EXPORT XLS</button>
            -->
        </div>
      </div>
      
      <div class="card-body">
        <table class="table table-sm table-data table-bordered">
          <thead>
            <tr>
                <th class="w120">Order No</th>
                <th class="w120">Date</th>
                <th class="">Job Name</th>
                <th class="">Customer</th>
                <th class="">Food</th>
                <th class="">Restourant</th>
                <th class="w120">Price</th>
                <th class="w120">Quantity</th>
                <th class="w120">Amount</th>
                <th class="w120">Total</th>
                <th class="w120">Status</th>
                <th class="w120">Action</th>
            </tr>
          </thead>
          <tbody>
              @if($rows )
                @foreach( $rows as $row )
                <?php 
                    if( $x == 0 || ( isset($node[$x-1]) && $node[$x-1] != $row->head_id ) ){
                        $hide = false;
                    }else{
                        $hide = true;
                    }
                    $amount = $row->per_price * $row->qty;
                    $total += $amount;
                ?>
                <tr>
                    <td>{{ ( $hide == false ) ? '#'. sprintf('%05d',$row->head_id) : '' }}</td>
                    <td>{{ ( $hide == false ) ? date('d M Y',strtotime( $row->created_at) ) :'' }}</td>
                    <td>@if($hide == false )<strong>{{ $row->jobname }}</strong><br/>{{ $row->address }}@endif</td>
                    <td>{{ ( $hide == false ) ? App\User::field( $row->user_id ): '' }}</td>
                    <td>{{ $row->food_name }}</td>
                    <td>{{ $row->restourant_name }}</td>
                    <td class="text-right">{{ $row->per_price }}</td>
                    <td class="text-right">{{ $row->qty }}</td>
                    <td class="text-right">{{ $amount }}</td>
                    <td class="text-right">{{ $total }}</td>
                    <td class="text-center">
                        {!! Lib::statusLabel( $row->status ) !!}
                    </td>

                    <td class="action">
                        <!--
                        <a title="Status update" class="text-success export-xls" href="#" data-id="{{ $row->head_id }}" ><i class="fa fa-file-excel-o"></i></a>
                        -->
                        <a title="Delete" class="text-danger export-pdf" href="{{ url('order/'. $row->head_id .'/export') }}" ><i class="fa fa-file-pdf-o"></i></a>
                    </td>
                </tr>
                <?php 
                    $node[$x] = $row->head_id; 
                    $x++;
                ?>
                @endforeach
              @endif
          </tbody>
        </table>
    </div>
    {!! $rows->links() !!}
</div>
@endsection
@section('modal')
    @include('backend.report.modal-form')
@endsection
@section('javascript')
    <script src="{{ asset('public/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/lib/moment.js') }}"></script>
    <script src="{{ asset('public/build/js/report-index.js') }}"></script>
@endsection
