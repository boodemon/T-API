@extends('backend.layouts.template')
@section('content')
<div class="card">
 <div class="card-header">
        <i class="fa fa-user"></i> {{ $subject }}
        <div class="pull-right">
        </div>
      </div>
      
      <div class="card-body">         <!-- Form category input -->
            <form enctype="multipart/form-data" class="form-horizontal" id="frm-category" method="POST" action="{{ url($action) }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="content_type" value="{{ $content_type }}"/>
            
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Subject: </label>
                    <div class="col-md-8">
                        <input type="text" id="subject" name="subject" class="form-control" value="{{ $row ? $row->subject : old('subject') }}" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Detail : </label>
                    <div class="col-md-10">
                        <textarea type="text" id="detail" name="detail" class="form-control" >{{ $row ? $row->detail : old('detail') }}</textarea>
                    </div>
                </div>
        
                <div class="form-groups text-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> SAVE</button>
                    <button type="button" class="btn btn-default btn-cancel"><i class="fa fa-save"></i> CANCEL</button>
                </div>
            </form>
</div>
</div>
@endsection
@section('javascript')
	<script src="{{asset('public/lib/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/tools/tiny-editor.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/build/js/contents.js')}}" type="text/javascript"></script>
    
@endsection
