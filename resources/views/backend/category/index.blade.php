@extends('backend.layouts.template')
@section('content')
<div class="card">
      <div class="card-header">
        <i class="fa fa-user"></i> Category food
        <div class="pull-right">
            <button type="button" id="btn-new" data-id="0" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New</button>
            <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</button>
        </div>
      </div>
      
      <div class="card-body">
        <table class="table table-sm table-data table-bordered">
          <thead>
            <tr>
              <th class="w60"><input type="checkbox" id="checkAll"/></th>
              <th class="w120">Image</th>
              <th>Name</th>
              <th class="w120">Show</th>
              <th class="w80">Sort</th>
              <th class="w120">Active</th>
              <th class="w120">Action</th>
            </tr>
          </thead>
          <tbody>
            @if( $rows )
            @foreach( $rows as $row)
            <tr>
              <td class="text-center">
                <input type="checkbox" class="checkboxAll" value="{{ $row->id }}" >
              </td>
              <td><img src="{{asset('public/images/category/' . $row->image) }}" class="img-responsive" width="120" /></td>
              <td>{{ $row->name }}</td>
              <td class="text-center">{{ strtoupper( $opts[$row->category_option] ) }}</td>
              <td class="text-center">{{ $row->category_sort }}</td>
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
    @include('backend.category.category-form')
@endsection
@section('javascript')
<script src="{{ asset('public/js/tools/image.js') }}"></script>
<script src="{{ asset('public/build/js/food-category.js') }}"></script>
@endsection