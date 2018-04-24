@extends('backend.layouts.template')
@section('content')
<div class="card">
    <div class="card-header">
        <i class="icon icon-basket"></i> Food data {{ '#' . sprintf( '%05d',$head->id ) }}
        <div class="pull-right">
            {{--  <button type="button" class="btn-sm btn btn-success btn-xls" title="Export Excel"><i class="fa fa-file-excel-o"></i> EXCEL</button>  --}}
            <a href="{{ url('order/'. $id .'/print')}}" class="btn-sm btn btn-default btn-print" title="Print order"><span class="text-dark"><i class="fa fa-print"></i> PRINT ORDER</span></a>
            <a href="{{ url('order/'. $id .'/export')}}" class="btn-sm btn btn-default btn-pdf" title="Export PDF"><span class="text-danger"><i class="fa fa-file-pdf-o"></i> EXPORT PDF</span></a>
        </div>
    </div>
      
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <strong>ORDER NO.</strong> 
                {{ '#' . sprintf( '%05d',$head->id ) }}
            </div>
            <div class="col-md-6 text-right">
                {{ date('d M Y', strtotime( $head->created_at ) ) }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"><strong>JOB NAME</strong></div>
            <div class="col-md-6">{{ $head->jobname }}</div>
            <div class="col-md-4 text-right"><strong>JOB DATE</strong> {{ date('d M Y H:i', strtotime( $head->jobdate ) ) }}</div>
        </div>
        <div class="row formgroup">
            <div class="col-md-2"><strong>JOB ADDRESS</strong></div>
            <div class="col-md-9">{{ $head->jobaddress }}</div>
        </div>
        <div class="row formgroup">
            <div class="col-md-2"><strong>REMARK</strong></div>
            <div class="col-md-5">{{ $head->remark }}</div>
            <div class="col-md-2 text-right"><strong>STATUS</strong></div>
            <div class="col-md-3">
                    <div class="input-group mb-3">
                        <div type="text" class="form-control">
                            {{ Lib::statusText( $head->status ) }}
                        </div>
                        <div class="input-group-append">
                            <a href="#" class="input-group-text onEdit" data-id="{{ $head->id }}" id="basic-addon2"><i class="icon icon-note"></i></a>
                        </div>
                    </div>
            </div>
        </div>
        <hr/>
        <div class="table-responsive">
                <table class="table table-sm table-data table-bordered">
                        <thead>
                          <tr>
                              <th class="w60">No</th>
                              <th class="">Food</th>
                              <th class="">Restourant</th>
                              <th class="w120">Price</th>
                              <th class="w120">Quantity</th>
                              <th class="w120">Amount</th>
                              <th class="w180">Remark</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if( $details )
                            @foreach( $details as $detail )
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ App\Models\Food::field($detail->food_id) }}</td>
                                <td>{!! App\Models\Restourant::showContact($detail->restourant_id) !!}</td>
                                <td class="text-right">{{ $detail->per_price }}</td>
                                <td class="text-right">{{ $detail->qty }}</td>
                                <td class="text-right">{{ $detail->total_price }}</td>
                                <td>{{ $detail->remark }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                              
                </table>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('backend.order.modal-form')
@endsection

@section('javascript')
    <script src="{{ asset('public/build/js/order-table.js') }}"></script>
@endsection