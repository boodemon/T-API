@extends('backend.layouts.template')
@section('stylesheet')
  <link href="{{ asset('public/lib/jquery-ui-1.12.1.full/jquery-ui.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="card">
 <div class="card-header">
        <i class="fa fa-user"></i> Food data
        <div class="pull-right">
        </div>
      </div>
      
      <div class="card-body">         <!-- Form category input -->
            <form enctype="multipart/form-data" class="form-horizontal" id="frm-category" method="POST" action="{{ url($action) }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="_method" value="{{ $_method }}"/>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label"></label>
                    <div class="col-md-10" id="file-preview">
                        @if( $row && $row->food_image )
                            <img src="{{ asset('public/images/foods/'. $row->food_image) }}" class="img-preview"/>
                        @endif
                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Image : </label>
                    <div class="col-md-10">
                        <input type="file" id="image" name="image" file-allow="jpg|jpeg|png|gif" />
                        <input type="hidden" id="id" id="id" name="id" value="{{ $id }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Food Name : </label>
                    <div class="col-md-8">
                        <input type="text" id="name" name="name" class="form-control" value="{{ $row ? $row->food_name : old('food_name') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Kcal : </label>
                    <div class="col-md-2">
                        <input type="text" id="kcal" name="kcal" class="form-control" value="{{ $row ? $row->kcal : old('kcal') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Food Group : </label>
                    <div class="col-md-6">
                        <select id="groups" name="groups" class="form-control">
                            <option value=''>- Select Group -</option>
                            {!! App\Models\Category::option( $selected ) !!}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Status : </label>
                    <div class="col-md-10">
                        <label class="checkbox">
                            <input type="checkbox" name="active" value="Y" {{ ($row && $row->active == 'Y') ? 'checked' : '' }} /> Active
                        </label>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <label class="form-control-label col-md-2">Restourant : </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="restourant" name="restourant" placholder="Restourant..." />
                    </div>
                    <label class="form-control-label col-md-2 text-right">Price : </label>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="price" value="" id="price" />
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-success btn-add"><i class="fa fa-plus"></i> ADD</button>
                    </div>
                </div>
                <h3>Restourant Price List</h3>
                <div class="form-group row price-list">
                </div>

                <div class="form-groups text-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> SAVE</button>
                    <button type="button" class="btn btn-outline-dark btn-cancel"><i class="fa fa-save"></i> CANCEL</button>
                </div>
            </form>
</div>
</div>
@endsection
@section('javascript')
    <script src="{{ asset('public/lib/jquery-ui-1.12.1.full/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/tools/image.js') }}"></script>
    <script src="{{ asset('public/build/js/food-form.js') }}"></script>
@endsection
