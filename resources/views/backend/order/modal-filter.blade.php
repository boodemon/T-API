<div class="modal fade"  tabindex="-1" id="order-filter" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title pull-left">Report Filter</h4>
            <button type="button" class="close pull-right" aria-label="Close"  data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Form category input -->
            <form enctype="multipart/form-data" class="form-horizontal" id="frm-status" method="GET" action="{{ url('order') }}">
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">STATUS</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="status">
                            <option value="">ALL</option>
                            @foreach( $status as $opt => $name )
                                <option value="{{ $opt }}" {{ Request::input('status') == $opt ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>                
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">BY</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="field">
                            @foreach( $field as $opt => $name )
                                <option value="{{ $opt }}" {{ Request::input('field') == $opt ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">KEYWORD</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="keywords" value="{{ Request::input('keywords') }}" placeholder="Keyword..." />
                    </div>
                </div>
                <div class="form-groups text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Filter
                    </button>
                </div>
            </form>
            <!-- /Form category input -->
          </div>
    </div>
    </div>
  </div>