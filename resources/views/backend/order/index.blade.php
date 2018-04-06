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
                <th class="w220">Amount</th>
                <th class="w120">status</th>
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
                    <td>{{ $row->price }}</td>
                    <td class="text-center">
                        <span class="label">{{ $row->status }}</span>
                    </td>
                    <td class="action">
                        <a title="Edit" class="text-primary" href="{{ url('order/'. $row->id .'/edit') }}" ><i class="icon-note"></i></a>
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
@endsection
@section('javascript')
    <script src="{{ asset('public/build/js/order-index.js') }}"></script>
@endsection
