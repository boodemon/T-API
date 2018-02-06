@extends('backend.layouts.template')
@section('content')
<div class="card">
      <div class="card-header">
        <i class="fa fa-user"></i> Payment data
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
                <th class="w220">Category</th>
                <th class="w220">Restourant</th>
                <th class="w60">Active</th>
                <th class="w80">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
</div>
@endsection