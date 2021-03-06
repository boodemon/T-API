<div class="modal fade"  tabindex="-1" id="modal-category" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title pull-left">Category Order</h4>
          <button type="button" class="close pull-right" aria-label="Close"  data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form category input -->
          <form enctype="multipart/form-data" class="form-horizontal" id="frm-category" method="POST" action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="hidden" name="id" id="id" />
            <input type="hidden" name="_method" />
            <div class="form-group row">
              <label class="col-md-2 form-control-label"></label>
              <div class="col-md-10" id="file-preview">
                <img src="" class="img-preview">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 form-control-label">Image : </label>
              <div class="col-md-10">
                <input type="file" id="image" name="image" file-allow="jpg|jpeg|png|gif" />
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 form-control-label">Name : </label>
              <div class="col-md-10">
              <input type="text" class="form-control" name="name" id="name" required/>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 form-control-label">Show : </label>
              <div class="col-md-4">
                <select name="category_option" class="form-control">
                  @foreach( $opts as $optCode => $optVal )
                    <option value="{{ $optCode }}">{{ $optVal }}</option>
                  @endforeach
                </select>
              </div>
              <label class="col-md-2 form-control-label">Sort : </label>
              <div class="col-md-3">
                <input type="text" class="form-control" name="category_sort" id="category_sort"/>
              </div>
            </div>
            
            <div class="form-group row">
              <label class="col-md-2 form-control-label">Status : </label>
              <div class="col-md-10">
              <label class="checkbox">
                <input type="checkbox" name="active" value="Y" /> Active
              </label>
              </div>
            </div>
          
            <div class="form-groups text-right">
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> SAVE</button>
              <button type="button" class="btn btn-danger"  data-dismiss="modal">
                <i class="fa fa-times"></i> CANCEL</button>
            </div>
          </form>
          <!-- /Form category input -->
        </div>
  </div>
  </div>
</div>