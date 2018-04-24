<div class="modal fade"  tabindex="-1" id="modal-order" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title pull-left">Order Status</h4>
            <button type="button" class="close pull-right" aria-label="Close"  data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Form category input -->
            <form enctype="multipart/form-data" class="form-horizontal" id="frm-status" method="POST" action="">
              <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
              <input type="hidden" name="_method" value="PUT"/>
  
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Status : </label>
                <div class="col-md-8">
                    <select name="status" class="form-control">
                      @foreach( Lib::statusValue() as $opt => $name )
                        <option value="{{ $opt }}">{{ $name }}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group row">
                    <label class="col-md-12 form-control-label">Message : </label>
                    <div class="col-md-12">
                        <textarea type="text" id="message" name="message" class="form-control" rows="6" ></textarea>
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