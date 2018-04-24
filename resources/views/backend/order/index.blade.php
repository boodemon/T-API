@extends('backend.layouts.template')
@section('content')
<div class="card">
      <div class="card-header">
        <i class="fa fa-user"></i> Food data
        <div class="pull-right">

        </div>
      </div>
      
      <div class="card-body">
        <table class="table table-sm table-data table-bordered">
          <thead>
            <tr>
                <th class="w20"><input type="checkbox" id="checkAll"/></th>
                <th class="w120">Order No</th>
                <th class="w120">Date</th>
                <th class="w120">Job Name</th>
                <th class="">Customer</th>
                <th class="w120">Amount</th>
                <th class="w120">Tracking</th>
                <th class="w120">Status</th>
                <th class="w80">Action</th>
            </tr>
          </thead>
          <tbody>
              @if($rows )
                @foreach( $rows as $row )
                <tr>
                    <td class="text-center">
                        <input type="checkbox" class="checkboxAll" value="{{ $row->id }}" >
                    </td>
                    <td>#{{ sprintf('%05d',$row->id) }}</td>
                    <td>{{ date('d M Y',strtotime( $row->created_at) ) }}</td>
                    <td>{{ $row->jobname }}</td>
                    <td>{{ App\User::field( $row->user_id ) }}</td>
                    <td class="text-right">{{ $row->price }}</td>
                    <td class="text-center">
                        <a href="#" data-id="{{ $row->id }}" class="onTracking"><i class="fa fa-truck fa-2x"></i></a>
                    </td>
                    <td class="text-center">
                        {!! Lib::statusLabel( $row->status ) !!}
                    </td>
                    <td class="action">
                        <a title="Order detail" class="text-success" href="{{ url('order/'. $row->id .'/edit') }}" ><i class="icon-magnifier"></i></a>
                        <a title="Status update" class="text-primary onEdit" href="#" data-id="{{ $row->id }}" ><i class="icon-note"></i></a>
                        <a title="Delete" class="text-danger onDelete" data-id="{{ $row->id }}" ><i class="icon-trash"></i></a>
                    </td>
                </tr>
                @endforeach
              @endif
          </tbody>
        </table>
    </div>
</div>
@endsection
@section('modal')
    @include('backend.order.modal-form')
    @include('backend.order.modal-tracking')
@endsection
@section('javascript')
    <script src="{{ asset('public/build/js/order-index.js') }}"></script>
@endsection
