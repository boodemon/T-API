<div class="modal fade"  tabindex="-1" id="modal-restourant" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title pull-left">Restourant food</h4>
            <button type="button" class="close pull-right" aria-label="Close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <!-- Form category input -->
            <form enctype="multipart/form-data" class="form-horizontal" id="frm-category" method="POST" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="_method" />
                <div class="form-group row">
                    <label class="col-md-2 form-control-label"></label>
                    <div class="col-md-10" id="file-preview">
                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Image : </label>
                    <div class="col-md-10">
                        <input type="file" id="image" name="image" file-allow="jpg|jpeg|png|gif" />
                        <input type="hidden" id="id" id="id" name="id" />
                    </div>
                </div>
        
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Groups : </label>
                    <div class="col-md-10">
                        <div class="row">
                            @if( $groups )
                            @foreach( $groups as $index => $group )
                            <div class="col-md-4">
                                <label>
                                    <input type="checkbox" name="groups[]" value="{{ $group['id']}}"/> 
                                    {{ $group['name']  }}
                                </label>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Name : </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="restourant" id="restourant" name="restourant" required/>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Contact : </label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="contact" id="contact" name="contact" required></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Tel : </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="tel" id="tel" name="tel" required/>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Status : </label>
                    <div class="col-md-10">
                        <label class="checkbox">
                        <input type="checkbox" id="active" name="active" /> Active
                        </label>
                    </div>
                </div>
        
                <div class="form-groups text-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> SAVE</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-save"></i> CANCEL</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>