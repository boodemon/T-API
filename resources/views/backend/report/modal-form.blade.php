<div class="modal fade"  tabindex="-1" id="modal-report" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <form enctype="multipart/form-data" class="form-horizontal" id="frm-status" method="GET" action="{{ url('report') }}">
                <div class="form-group row input-daterange">
                    <label class="col-md-2 form-control-label">Start : </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="start" id="start" value="{{ date('Y-m-d', strtotime( $start ) ) }}"/>
                    </div>
                    <label class="col-md-2 text-right form-control-label">End : </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="end" id="end" value="{{ date('Y-m-d', strtotime( $end ) ) }}"/>
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