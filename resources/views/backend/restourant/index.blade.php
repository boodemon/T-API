@extends('backend.layouts.template')
@section('content')
<div class="card">
      <div class="card-header">
        <i class="fa fa-user"></i> Restourant food
        <div class="pull-right">
            <button type="button" id="btn-new" data-id="0" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New</button>
            <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</button>
        </div>
      </div>
      
      <div class="card-body">
        <table class="table table-sm table-data table-bordered">
          <thead>
            <tr>
                <th><input type="checkbox" id="checkAll"/></th>
                <th>Image</th>
                <th>Restourant</th>
                <th>Groups</th>
                <th>Active</th>
                <th>Action</th>
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
                <img src="{{asset('public/images/restourant/' . $row->image) }}" class="img-responsive" width="120" />
              </td>
              <td>
                  <p><strong>{{ $row->restourant }}</strong></p>
                  <p>{{ $row->contact }} </p>
                  <p>Tel. {{ $row->tel }}</p>
              </td>
              <td>
                  {{ App\Models\Category::groupName( @explode(',', $row->category_id ) ) }}
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
        {!! $rows->links() !!}
      </div>
    </div>
@endsection


@section('modal')
    @include('backend.restourant.restourant-form')
@endsection
@section('javascript')
<script src="{{ asset('public/js/tools/image.js') }}"></script>
<script src="{{ asset('public/build/js/food-restourant.js') }}"></script>
@endsection