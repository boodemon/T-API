@extends('backend.layouts.template')
@section('content')
<div class="card">
      <div class="card-header">
        <i class="fa fa-user"></i> Food data
        <div class="pull-right">
            <button type="button" id="btn-new" data-id="0" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New</button>
            <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</button>
        </div>
      </div>
      
      <div class="card-body">
        <table class="table table-sm table-data table-bordered">
          <thead>
            <tr>
                <th class="w20"><input type="checkbox" id="checkAll"/></th>
                <th class="w120">Image</th>
                <th>Food name</th>
                <th class="w120">Calorie</th>
                <th class="w220">Category</th>
                <th class="w220">Restourant</th>
                <th class="w60">Active</th>
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
                    <td>
                        <img src="{{asset('public/images/foods/' . $row->food_image ) }}" class="img-responsive" width="120" />
                    </td>
                    <td>{{ $row->food_name }}</td>
                    <td class="text-right">{{ $row->kcal }} (kcal)</td>
                    <td>{{ @$group[$row->category_id]['name']}}</td>
                    <td class="text-center"><a href="#" class="show-price" food-id="{{ $row->id }}" title="Click show price list of food">{{ App\Models\Price::unit( $row->id ) }} ร้าน</a></td>
                    <td class="text-center">
                        {!! Lib::active( $row->active ) !!}
                    </td>
                    <td class="action">
                        <a title="Edit" class="text-primary" href="{{ url('foods/food/'. $row->id .'/edit') }}" ><i class="icon-note"></i></a>
                        <a title="Delete" class="text-danger onDelete" data-id="{{ $row->id }}" ><i class="icon-trash"></i></a>
                    </td>
                </tr>
                @endforeach
              @endif
          </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $rows->links() !!}
    </div>
</div>
@endsection
@section('modal')
    @include('backend.food.modal-price')
@endsection
@section('javascript')
    <script src="{{ asset('public/build/js/food-index.js') }}"></script>
@endsection
