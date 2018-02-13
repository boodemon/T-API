@extends('backend.layouts.template')
@section('content')
<div class="card">
      <div class="card-header">
        <i class="fa fa-user"></i> Payment data
        <div class="pull-right">
            <button type="button" id="btn-new" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New</button>
            <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</button>
        </div>
      </div>
      
      <div class="card-body">
        <table class="table table-sm table-data table-bordered">
          <thead>
            <tr>
                <th class="w40"><input type="checkbox" id="checkAll"/></th>
                <th class="w120">Image</th>
                <th>รายละเอียดบัญชี</th>
                <th class="w60">สถานะ</th>
                <th class="w80">Action</th>
            </tr>
          </thead>
          <tbody>
            @if( $rows )
            @foreach( $rows as $row)
            <tr>
              <td class="text-center">
                <input type="checkbox" class="checkboxAll" value="{{ $row->id }}" >
              </td>
              <td>
                <img src="{{asset('public/images/bank/' . $row->bank_image) }}" class="img-responsive" width="120" />
              </td>
              <td>
                  <p>ธนาคาร <strong>{{ $row->bank_name }}</strong> สาขา <strong>{{ $row->bank_branch }}</strong></p>
                  <p>ประเภทบัญชี <strong>{{ $row->bank_type }}</strong></p>
                  <p>ชื่อบัญชี <strong>{{ $row->bank_account }}</strong> </p>
                  <p>เลขที่ <strong>{{ $row->bank_id }}</strong> </p>
              </td>
              <td class="text-center">
                    {!! Lib::active($row->active) !!}
              </td>
              <td class="action">
                  <a title="Edit" class="text-primary onEdit" data-id="{{ $row->id }}" ><i class="icon-note"></i></a>
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
    @include('backend.payment.modal-form')
@endsection
@section('javascript')
<script src="{{ asset('public/js/tools/image.js') }}"></script>
<script src="{{ asset('public/build/js/payment-index.js') }}"></script>
@endsection